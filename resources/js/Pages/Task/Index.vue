<template>
<div class="w-96 mx-auto pt-8">
    <h1>Проекты</h1>
    <div class="mb-4">
        <Link :href="route('project.index')" class="block p-2 w-32 text-center text-nowrap bg-gray-300 rounded">К проектам</Link>
    </div>
    <div class="mb-4">
        <Link :href="route('task.create')" class="block p-2 w-32 text-center text-nowrap bg-green-300 rounded">Создать задачу</Link>
    </div>
    <table>
        <thead class="border bg-gray-500">
        <tr>
            <th>Задача</th>
            <th>В проекте</th>
            <th>Создан</th>
            <th>Автор</th>
            <th>Исполнитель</th>
            <th>Прогресс</th>
            <th>Всего потрачено времени</th>
            <th>Описание</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

                <tr v-for="task in tasks" class="border-b border-gray-300">
                    <th>{{task.title}}</th>
                    <th>
                        <Link :href="route('project.show', task.project_id)" class="text-indigo-600 w-32 p-1 text-center rounded">{{task.project_title}}</Link>
                    </th>
                    <th>{{task.created_at}}</th>
                    <th>{{task.author}}</th>
                    <th>{{task.performer}}</th>
                    <th>{{task.progress}}</th>
                    <th>{{task.difference}}</th>
                    <th>{{task.overview}}</th>
                    <th>
                        <Link :href="route('task.show', task.id)" class="bg-indigo-200 w-32 p-1 text-center rounded">Посмотреть</Link>
                    </th>
                </tr>

        </tbody>
    </table>

</div>



</template>

<script>
import {Link} from "@inertiajs/vue3";
export default {
    name: "Index",

    props: [
        'projects',
        'tasks'
    ],

    components: {
        Link,
    }
}
</script>

<style scoped>

</style>
