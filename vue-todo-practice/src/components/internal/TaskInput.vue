<script setup>

    import { ref } from 'vue';

    import { onMounted, useTemplateRef } from 'vue';
    import { useTodoStore } from './../../stores/Todo';

    import { POST } from '@/scripts/Fetch';

    // vue notification toast
    import { ShowToast } from '@/scripts/Toast';

    const emit = defineEmits(['hide']);

    const TodoStore = useTodoStore();

    let Title = '';
    let Description = '';
    let title = useTemplateRef('title');
    let isTitleError = ref(false);

    const InputValidation = (title, desc) => {
        if (title.length <= 5) return true;
        else return false;
    };

    const AddTask = async () => {
        // validation
        isTitleError.value = InputValidation (Title, Description);
        if (isTitleError.value) return;

        // update new task to store
        TodoStore.TaskList.unshift({
            id: 0,
            title: Title,
            description: Description == null ? '' : Description,
            completed: false
        });

        // hide input box
        TodoStore.ShowInputBox = false;
        TodoStore.UnreadActivities += 1;

        // add task to database
        let formData = new FormData();
        formData.append('title', Title);
        formData.append('description', Description);

        // create new task 
        let result = await POST('task/create', formData);

        // now update the real id of current task
        let newId = result.response.id;
        TodoStore.TaskList.map(task => {
            if (task.id == 0) task.id = newId;
            return task;
        });
        

        // show notification
        ShowToast('Task Added Successfully!', 'top');
        
    };

    // focus the title input when component mounted
    onMounted(() => {
        title.value.focus();
    });

</script>

<template>
    <div class="input-box">
        <div class="input">
            <input type="text" :class="isTitleError ? '__error' : ''" ref="title" v-model="Title" placeholder="Title">
            <input type="text" v-model="Description" placeholder="Description">
        </div>
        <div class="button">
            <button @click="emit('hide')">Cancel</button>
            <button class="addbtn" @click="AddTask">Add task</button>
        </div>
    </div>
</template>