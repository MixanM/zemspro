<template>
<div class="w-96 mx-auto pt-8">
    <h1>Создать задачу</h1>
    <form @submit.prevent="store">
        <div>
            <input required v-model="title" class="w-full rounded" type="text" placeholder="Название задачи">
        </div>
        <div>
            <textarea v-model="overview" class="w-full rounded" name="" id="" cols="30" rows="10" placeholder="Описание задачи"></textarea>
        </div>
        <div class="flex justify-between  mb-4">
            <label>Для проекта</label>
            <select id="projects" name="project" class=" object-right">
                <option v-for="project in projects" :value="project.id" >{{project.title}}</option>
            </select>
        </div>
        <div class="flex justify-between ">
            <button type="submit" class="block p-2 w-32 text-center text-nowrap bg-green-300 rounded">Сохранить</button>
            <Link :href="route('project.index')" class="object-right block p-2 w-32 text-center text-nowrap bg-gray-200 rounded">Отмена</Link>
        </div>

    </form>
</div>



</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",
    props: [
        'projects',
    ],
    components: {
        Link,
    },

    data(){
        return {
            title: '',
            overview:'',
        }
    },

    methods:{
        store (event){
            const projectId = event.target.project.value; // Получаем id выбранного проекта
            this.$inertia.post('/task', {title: this.title, overview: this.overview, project_id: projectId})
        }
    }
}
</script>

<style scoped>

</style>
