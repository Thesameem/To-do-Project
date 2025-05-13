<script setup>

    import { ref } from 'vue';

    import { onMounted, useTemplateRef } from 'vue';
    import { useTodoStore } from './../../stores/Todo';

    // vue notification toast
    import {useToast} from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';

    const emit = defineEmits(['hide']);

    const TodoStore = useTodoStore();

    let Title = '';
    let title = useTemplateRef('title');
    let Description = '';
    let isTitleError = ref(false);

    const InputValidation = (title, desc) => {
        if (title.length <= 5) return true;
        else return false;
    };

    const AddTask = () => {
        // validation
        isTitleError.value = InputValidation (Title, Description);
        if (isTitleError.value) return;

        // update new task to store
        TodoStore.TaskList.unshift({
            id: Math.floor(Math.random()*99999),
            title: Title,
            description: Description,
            completed: false
        });

        // hide input box
        TodoStore.ShowInputBox = false;

        // show notification
        const toast = useToast();
        toast.success('Task Added Successfully!', {
            position: 'top',
        });
        
    };

    // mount
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