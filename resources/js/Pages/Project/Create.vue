<template>
<div class="w-96 mx-auto pt-8">
    <h1>Создание проекта</h1>
    <form @submit.prevent="store">
        <div>
            <input required v-model="title" class="w-full rounded" type="text" placeholder="Название нового проекта">
        </div>
        <div>
            <textarea v-model="overview" class="w-full rounded" id="" cols="30" rows="10" placeholder="Описание проекта"></textarea>
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

    data(){
        return {
            title: '',
            overview:'',
        }
    },

    methods:{
        store (){
            this.$inertia.post('/project', {title: this.title, overview: this.overview, __method:'PUT'})
        }
    }
}
</script>

<style scoped>

</style>
