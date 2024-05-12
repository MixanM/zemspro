<template>
<div class="w-96 mx-auto pt-8">
    <h1>Редактирование проекта {{project.title}}</h1>
    <form @submit.prevent="update">
        <div>
            <input required v-model="title" class="w-full rounded" type="text" placeholder="Название нового проекта" value={{project.title}}>
        </div>
        <div>
            <textarea v-model="overview" class="w-full rounded" name="" id="" cols="30" rows="10" placeholder="Описание проекта"></textarea>
        </div>
        <div class="flex justify-between">
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
    components: {
        Link,
    },

    props:[
      'project',
    ],

    data(){
        return {
            id: this.project.id,
            title: this.project.title,
            overview: this.project.overview,
        }
    },

    methods:{
        update (){
            this.$inertia.patch('/project/'+this.project.id, {title: this.title, overview: this.overview});
        }
    }
}
</script>

<style scoped>

</style>
