<template>
<div class="w-96 mx-auto pt-8">
    <h1>Задача {{items.title}}</h1>
    <div class="mb-4">
        <Link :href="route('task.index')" class="block p-2 w-32 text-center text-nowrap bg-gray-300 rounded">К списку задач</Link>
    </div>
    <table>
        <thead>
        <tr>
            <th>Задача</th>
            <th>Статус</th>
            <th>Затрачено времени</th>
            <th>Автор</th>
            <th>Описание</th>
            <th>Исполнитель</th>
            <th>Старт</th>
            <th>Закончена</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{task.title}}</td>
            <td>{{task.status}}</td>
            <td>{{task.difference}}</td>
            <td>{{items.author}}</td>
            <td>{{task.overview}}</td>
            <td>{{task.performer}}</td>
            <td>{{task.start}}</td>
            <td>{{task.stop}}</td>
        </tr>
        </tbody>
    </table>
    <div>

        <Link @click="updateTask(task.id, 1, task.project_id)" v-if="task.start === null" class="bg-green-300">Начать</Link>
        <Link @click="updateTask(task.id, 0, task.project_id)" v-if="task.status_id === 1" class="bg-sky-200">Закончить</Link>
        <Link :href="route('task.edit', task.id)" class="bg-gray-300">Редактировать</Link>
        <Link @click="updateTask(task.id, 3, task.project_id)" class="bg-red-200 w-32 p-1 text-center rounded">Удалить</Link>


    </div>
</div>


</template>

<script>
import {Link} from "@inertiajs/vue3";
export default {
    name: "Index",

    props: [
        'task', 'items',
    ],

    components: {
        Link,
    },

    methods :{
         updateTask(taskID , par, project_id)
        {
            console.log(taskID , par, project_id);
               this.$inertia.patch('/task/'+taskID, {par, project_id});
        },
      },
}
</script>

<style scoped>

</style>
