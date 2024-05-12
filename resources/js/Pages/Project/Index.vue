<template>
    <div>
        <Link :href="route('profile.edit')"> Profile </Link>
        <Link :href="route('logout')" method="post" as="button">
            Log Out
        </Link>
    </div>
    <div class="w-96 mx-auto pt-8">
        <h1>Проекты</h1>
        <div class="mb-4">
            <Link :href="route('project.create')" class="block p-2 w-32 text-center text-nowrap bg-green-300 rounded">Создать проект</Link>
        </div>
        <div class="mb-4">
            <Link :href="route('task.index')" class="block p-2 w-32 text-center text-nowrap bg-sky-300 rounded">Список задач</Link>
        </div>
        <table>
            <thead class="border bg-gray-500">
            <tr>
                <th>Проект</th>
                <th>Статус</th>
                <th>Создан</th>
                <th>Автор</th>
                <th>Прогресс</th>
                <th>Всего потрачено времени</th>
                <th>Описание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="project in projects" class="border-b border-gray-300">
                <th>{{project.title}}</th>
                <th>{{project.status_title}}</th>
                <th>{{project.created_at}}</th>
                <th>{{project.user_name}}</th>
                <th>Готово {{ project.tasks_status_2 }} из {{ project.total_tasks }}</th>
                <th>
                    {{ formatTime(project.total_time) }}
                </th>
                <th>{{project.overview}}</th>
                <th>
                    <Link :href="route('project.show', project.id)" class="bg-sky-200 w-32 p-1 text-center rounded">Посмотреть</Link>
                    <Link :href="route('project.edit', project.id)" class="bg-indigo-200 w-32 p-1 text-center rounded">Редактировать</Link>
                    <Link @click="deletePost(project.id)" class="bg-red-200 w-32 p-1 text-center rounded">Удалить</Link>
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
        'projects'
    ],

    components: {
        Link,
    },

    methods: {
        formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            return `${hours}:${minutes}:${seconds}`;
        },

        deletePost(id) {
            this.$inertia.delete('/project/' + id)
        },
    },
}
</script>

<style scoped>

</style>
