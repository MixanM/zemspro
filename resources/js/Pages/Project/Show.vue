<template>
<div class="w-96 mx-auto pt-8">
    <h1>Проект {{project.title}}</h1>
    <div class="mb-4">
        <Link :href="route('project.index')" class="block p-2 w-32 text-center text-nowrap bg-gray-300 rounded">К проектам</Link>
    </div>
    <div v-if="!tasks.length">
        <p>Задач нет</p>
    </div>
    <div v-else>
        <table class="border-collapse border-separate border border-slate-400">
            <thead class="bg-gray-100">
            <tr>
                <th>Задача</th>
                <th>Статус</th>
                <th>Затрачено времени</th>
                <th>Автор</th>
                <th>Исполнитель</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks" class="border-b border-gray-300">
                <td class="border border-slate-300">{{task.title}}</td>
                <td class="border border-slate-300">{{task.status_title}}</td>
                <td class="border border-slate-300">{{ task.difference }}</td>
                <td class="border border-slate-300">{{task.user_author}}</td>
                <td class="border border-slate-300">{{task.user_performer}}</td>
                <td class="border border-slate-300">
                    <Link :href="route('task.show', task.id)" class="bg-gray-200 w-32 p-1 text-center rounded">Посмотреть</Link>
                    <Link v-if="task.status_title === null" @click="updateTask(task.id, 1, project.id)" class="bg-sky-200 w-32 p-1 text-center rounded">Начать</Link>
                    <Link v-if="task.status_title === 'Исполняется'" @click="updateTask(task.id, 0, project.id)" class="bg-green-200 w-32 p-1 text-center rounded">Закончить</Link>
                    <Link @click="updateTask(task.id, 3, project.id)" class="bg-red-200 w-32 p-1 text-center rounded">Удалить</Link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div>
        <button @click="openModal" class="bg-green-300">Создать задачу</button>
    </div>
    <!-- Модальное окно -->
    <transition name="modal">
        <div class="modal" v-if="showModal">
            <div class="modal-overlay" @click.self="closeModal"></div>
            <div class="modal-content">
                <h2>Создание задачи</h2>
                <form @submit.prevent="createTask(project.id)">
                    <div>
                        <input required v-model="title" class="w-full rounded" type="text" placeholder="Название задачи">
                    </div>
                    <div>
                        <textarea v-model="overview" class="w-full rounded" name="" id="" cols="30" rows="10" placeholder="Описание задачи"></textarea>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="block p-2 w-32 text-center text-nowrap bg-green-300 rounded">Сохранить</button>
                        <button @click="closeModal" class="block p-2 w-32 text-center text-nowrap bg-gray-200 rounded">Отмена</button>
                    </div>
                </form>
            </div>
        </div>
    </transition>
</div>

</template>

<script>
import {Link} from "@inertiajs/vue3";
export default {
    name: "Index",

    props: [
        'tasks', 'project'
    ],

    components: {
        Link,
    },

    data() {
        return {

            showModal: false,
            title: "",
            overview: "",
        };
    },

    methods: {
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },

        createTask(project_id)
        {
            this.$inertia.post('/task', {title: this.title, overview: this.overview, project_id});
            this.showModal = false;
        },

        updateTask(taskID , par, project_id)
        {
            this.$inertia.patch('/task/'+taskID, {par, project_id});
        },

    },
}
</script>

<style scoped>

</style>
