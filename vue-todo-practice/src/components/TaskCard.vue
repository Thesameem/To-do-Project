<script setup>

    import { ref } from 'vue';

    import { useTodoStore } from './../stores/Todo';


    // vue notification toast
    import {useToast} from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';
import { GET, POST } from '@/scripts/Fetch';

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

    const InputValidation = (title, desc) => {
        if (title.length <= 5) return true;
        else return false;
    };

    // edit
    const SaveData = async() => {

      // validation
      isTitleError.value = InputValidation (title, description);
      if (isTitleError.value) return;


      props.task.title = title;
      props.task.description = description;

      // remove edit mode
      props.task.edit = false;

      // show notification
      const toast = useToast();
        toast.success('Task Updated', {
          position: 'top',
        });


        
    let formData = new FormData();
    formData.append('title',title);
    formData.append('description',desctiption);

    let result =  await POST('tasks/update' + props.task.id ,formData);
    console.log(result);
    };





    const CompleteToggle = async() => {
      // first update the task
      props.task.completed = !props.task.completed;

      //re-arrage all task
      TodoStore.ReArrangeTasks();

      //update to databse

      let result =await GET('tasks/complete/' + props.task.id);
      console.log(result);
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

        <!-- buttons to edit and delet task -->
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