<script setup>
    
    import { ref, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import { useTodoStore } from './../stores/Todo';

    import Cookie from '@/scripts/Cookie';
    import { DELETE, GET } from '@/scripts/Fetch'; // axios to delete and get request


    // vue notification toast
    import { ShowToast } from '@/scripts/Toast';

    // components
    import Header from './../components/Header.vue';
    import TaskCard from './../components/TaskCard.vue';
    import EmptyTask from './../components/EmptyTask.vue';
    import DeleteModal from './../components/DeleteModal.vue';

    // activities page
    import Activities from './../components/Activities.vue';

    // pinia store
    const TodoStore = useTodoStore();

    // router to navigate different urls
    const router = useRouter();

    // delete todos stuff
    let ShowDeleteModal = ref(false);
    let WantToDelete = ref({});

    // show delete modal
    const ShowDeleteBox = (task) => {
      WantToDelete.value = task;     
      ShowDeleteModal.value = true;
    };

    // this function will be call after user click upon a 'delete' button from a model
    // it will remove selected todo from store and from server as well.
    const DeleteTask = () => {
        // find task index
        let index = TodoStore.TaskList.findIndex(element => {
          if (WantToDelete.value.id == element.id) return true;
        });

        // remove task
        TodoStore.TaskList.splice(index, 1);
        TodoStore.UnreadActivities += 1;

        // delete from database
        let result = DELETE('task/delete/' + WantToDelete.value.id);

        // show notification
        ShowToast('Task Deleted', 'top');

        // hide delete modal
        ShowDeleteModal.value = false;
    };

    // when the Dashboard component mounted
    // This will check cookie for token, if not found navigate to /auth (login page)
    // if token found, request will be made to list task and activities etc.
    onMounted(async () => {
      let Token = Cookie.getCookie('todo-app');
      if (!Token) {
        router.push({path: '/auth'});
        return;
      }

      // get current user's tasks and activities and save to todo store
      let result = await GET('user/tasks');
      if (!result.error) {
        TodoStore.TaskList = result.response.tasks;
        TodoStore.Activities = result.response.activities;
        TodoStore.ReArrangeTasks();

        // count total number of unread activities and notify user on bell icon
        TodoStore.Activities.filter(activity => {
          if (activity.unread) TodoStore.UnreadActivities += 1;
        });
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