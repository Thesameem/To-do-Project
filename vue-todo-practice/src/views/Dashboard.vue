<script setup>
    
    import { ref ,onMounted} from 'vue';
    import { useRouter } from 'vue-router';
    import Cookie from '@/scripts/Cookie';
    import { useTodoStore } from './../stores/Todo';
    import axios from 'axios';
    import {GET} from '@/scripts/Fetch';
    import { DELETE } from '@/scripts/Fetch';

    // vue notification toast
    import {useToast} from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';

    // components
    import Header from './../components/Header.vue';
    import TaskCard from './../components/TaskCard.vue';
    import EmptyTask from './../components/EmptyTask.vue';
    import DeleteModal from './../components/DeleteModal.vue';

    import Activities from './../components/Activities.vue';

    let router = useRouter();

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
        //delete from database
        let result = DELETE('tasks/delete/' + WantToDelete.value.id);

        // show notification
        const toast = useToast();
        toast.success('Task Deleted', {
          position: 'top',
        });

        // hide delete modal
        ShowDeleteModal.value = false;
    };



    onMounted(async()=>{
      let Token =Cookie.getCookie('todo-app');
      if(!Token){
        router.push ({
          path:'/auth'
        });
        return;
      }

      let result = await GET('user/tasks');
      if(!result.error) {
        TodoStore.TaskList = result.response;
        TodoStore.ReArrangeTasks();
      }
    });
</script>

<template>
    <div class="todo-app" v-if="!TodoStore.ShowActivity">
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

    <div class="todo-app" v-else>
      <Activities @close="TodoStore.ShowActivity = false" />
    </div>


</template>