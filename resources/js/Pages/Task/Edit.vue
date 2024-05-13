<template>
<div class="w-96 mx-auto pt-8">
    <h1>Задача {{task.title}}</h1>
    <div class="mb-4">
        <Link :href="route('task.index')" class="block p-2 w-32 text-center text-nowrap bg-gray-300 rounded">К списку задач</Link>
    </div>
    <form @submit.prevent="update">
        <div>
            <input required v-model="title" class="w-full rounded" type="text" placeholder="Название задачи">
        </div>
        <div>
            <textarea v-model="overview" class="w-full rounded" name="" id="" cols="30" rows="10" placeholder="Описание задачи"></textarea>
        </div>
        <div class="flex justify-between  mb-4">
            <label>Для проекта</label>
            <select id="projects" name="project" class=" object-right">
                <option v-for="project in projects" :value="project.id" :selected="project.id === task.project_id">{{project.title}}</option>
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
        'task', 'projects', 'user'
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

    methods:{
      update(event){
          const projectId = event.target.project.value; // Получаем id выбранного проекта
          this.$inertia.patch('/task/'+this.task.id, {title: this.title, overvew : this.overview, project_id : projectId , par:2});
      }
    },
}
</script>

<style scoped>

</style>
