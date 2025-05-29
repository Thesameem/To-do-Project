import { defineStore } from "pinia";

export const useTodoStore = defineStore('todo', {
    state: () => ({        
        user: {},
        TaskList: [],
        Activities: [],
        UnreadActivities: 0,
        
        ShowInputBox: false,
        ShowActivity: false
    }),
    
    actions: {
        ReArrangeTasks () {
            // sort task desc using id
            this.TaskList.sort((a, b) => {
                if (a.id < b.id) return 1;
                else if (a.id > b.id) return -1;
                else return 0
            });

            // re-arrange all tasks
            const Incompleted = [];
            const Completed = [];

            this.TaskList.map(task => {
                if (task.completed) Completed.push(task);
                else Incompleted.push(task);
            });

            const Arranged = Incompleted.concat(Completed);
            this.TaskList = Arranged;
        }
    },
  });