<script setup>

    import { ref } from 'vue';

    import { useTodoStore } from './../stores/Todo';
    import { GET, POST } from '@/scripts/Fetch';


    // vue notification toast
    import { ShowToast } from '@/scripts/Toast';

    // pinia
    const TodoStore = useTodoStore();

    // props
    const props = defineProps({
        task: {
            type: Object,
            default: {}
        }
    });

    // emits
    const emit = defineEmits(['delete', 'edit']);

    // edit inputs
    let title = props.task.title;
    let description = props.task.description;
    let isTitleError = ref(false);

    // show edit model to the todo list
    const WantToEditTask = () => {
      TodoStore.TaskList = TodoStore.TaskList.filter(element => {
        if (props.task.id == element.id) {
          element.edit = true;
        }else {
          element.edit = false;
        }

        return true;
      });
    }

    // todo input validation with length
    const InputValidation = (title, desc) => {
        if (title.length <= 5) return true;
        else return false;
    };

    // edit
    const SaveData = () => {

      // validation
      isTitleError.value = InputValidation (title, description);
      if (isTitleError.value) return;


      props.task.title = title;
      props.task.description = description;

      // remove edit mode
      props.task.edit = false;

      // show notification
      ShowToast('Task Updated!', 'top');

      TodoStore.UnreadActivities += 1;

      let formData = new FormData();
      formData.append('title', title);
      formData.append('description', description);
      let result = POST('task/update/' + props.task.id, formData);
        
    };

    // complete and incomplete todo 
    const CompleteToggle = async () => {
      // first update the task
      props.task.completed = !props.task.completed;

      // re-arrange all tasks
      TodoStore.ReArrangeTasks();

      TodoStore.UnreadActivities += 1;

      // update to database
      let result = await GET('task/complete/' + props.task.id);

      // notify
      ShowToast('Task Updated!', 'top');
    }


</script>

<template>
    <li :class="[task.completed ? 'complete' : '', task.edit ? 'edit' : '']" v-if="!task.matched">
        <!-- task complete action -->
        <div class="radio" @click="CompleteToggle()"></div>

        <!-- task title desc -->
        <div class="content" v-if="!task.edit">
            <h3>{{ task.title }}</h3>
            <p>{{ task.description }}</p>
        </div>

        <!-- edit mode -->
        <div v-else class="input">
          <input type="text" :class="isTitleError ? '__error' : ''" v-model="title" placeholder="Title">
          <textarea v-model="description" placeholder="Description"></textarea>
        </div>

        <!-- buttons to edit and delete task -->
        <div class="action">
            <img @click="WantToEditTask" src="./../images/edit.svg" />
            <img @click="emit('delete', task)" src="./../images/delete.svg" />
        </div>

        <!-- action after edit mode -->
        <div class="editaction">
            <button @click="task.edit = false">Cancel</button>
            <button class="addbtn" @click="SaveData">Save</button>
        </div>
    </li>
</template>