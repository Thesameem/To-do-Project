let Storage = window.localStorage;

export const SaveTasks = (tasks) => {
    Storage.setItem('todo-list', JSON.stringify(tasks));
    return true;
}

export const GetTasks = () => {
    let tasks = Storage.getItem('todo-list');
    return JSON.parse(tasks);
}