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

            <Link v-if="task.start === null">Начать</Link>
            <Link v-if="task.status_id === 1">Закончить</Link>
            <Link>Удалить</Link>
            <Link :href="route('task.edit', task.id)">Редактировать</Link>
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
}
</script>

<style scoped>

</style>
