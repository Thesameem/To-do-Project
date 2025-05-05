<script setup>

    import { ref } from 'vue';

    import { useTodoStore } from './stores/Todo';

    import { SaveTasks } from './scripts/LocalDB';

    // vue notification toast
    import {useToast} from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';

    // components
    import Header from './components/Header.vue';
    import TaskCard from './components/TaskCard.vue';
    import EmptyTask from './components/EmptyTask.vue';
    import DeleteModal from './components/DeleteModal.vue';

    // pinia store
    const TodoStore = useTodoStore();

    let ShowDeleteModal = ref(false);
    let WantToDelete = ref({});

    // show delete modal
    const ShowDeleteBox = (task) => {

      WantToDelete.value = task;     
      ShowDeleteModal.value = true;

    };


    const DeleteTask = () => {
        // find task index
        let index = TodoStore.TaskList.findIndex(element => {
          if (WantToDelete.value.id == element.id) return true;
        });

        // remove task
        TodoStore.TaskList.splice(index, 1);

        // update to local db
        SaveTasks(TodoStore.TaskList);

        // show notification
        const toast = useToast();
        toast.success('Task Deleted', {
          position: 'top',
        });

        // hide delete modal
        ShowDeleteModal.value = false;
    };

    

    

</script>

<template>
  <div class="todo-app">
    <Header />

    <ul class="todo-list">
        <TaskCard v-for="task in TodoStore.TaskList" :key="task.id" 
                :task="task"
                @delete="ShowDeleteBox" />
    </ul>

    <EmptyTask v-if="TodoStore.TaskList.length == 0" />

    <Teleport to="body">
      <DeleteModal v-if="ShowDeleteModal" 
                    :task="WantToDelete"
                    @hide="ShowDeleteModal = false"
                    @delete="DeleteTask" />
    </Teleport>
      
</div>
</template>