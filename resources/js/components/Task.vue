<template>
    <div class="shadow-sm p-2 my-3 bg-body rounded m-0 task-item">
        <div class="float-end">
            <i @click="deleteTask" class="fal fa-trash-alt task-edit-btn text-danger me-2"></i>
            <i class="fal fa-pencil task-edit-btn"></i>
        </div>
        <strong v-text="task.title"/>
        <small class="d-block text-muted text-uppercase">
            <i class="fal fa-file-alt"></i>
            description
        </small>
        <p v-text="task.detail"/>
    </div>
</template>

<script>
    export default {
        props: ['task'],
        methods: {
            updateTask(){

            },
            deleteTask(){
                if (confirm('Are u sure delete task?')) {
                    this.$store.dispatch('deleteTask', this.task)
                }
            },
        }
    }
</script>
