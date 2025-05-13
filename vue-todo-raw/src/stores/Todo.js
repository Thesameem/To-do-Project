import { defineStore } from "pinia";

export const useTodoStore = defineStore('todo', {
    state: () => ({        
        user: {},
        TaskList: [],
        Activities: [],
        
        ShowInputBox: false,
        ShowActivity: false,        
    }),
    
    actions: {

    },
  });