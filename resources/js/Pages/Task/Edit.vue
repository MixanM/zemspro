<template>
<div class="w-96 mx-auto pt-8">
    <h1>Задача {{task.title}}</h1>
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
            <th>Исполнитель</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <Link>Сохранить</Link>
                <Link>Отмена</Link>
            </td>
        </tbody>
    </table>
</div>


</template>

<script>
import {Link} from "@inertiajs/vue3";
export default {
    name: "Index",

    props: [
        'task'
    ],

    data(){
        return {
            id: this.task.id,
            title: this.task.title,
            overview: this.task.overview,
            project_id: this.task.project_id,
        }
    },

    components: {
        Link,
    },
}
</script>

<style scoped>

</style>
