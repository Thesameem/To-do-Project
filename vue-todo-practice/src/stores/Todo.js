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

        ReArrangeTasks(){
            //re- arrange all task

            const Incompleted =[];
            const Completed = [];

            this.TaskList.map(task =>{
                if(task.completed) Completed.push(task);
                else Incompleted.push(task);
            });

            const Arranged = Incompleted.concat(Completed);
            this.TaskList =Arranged;
        }

    },
  });