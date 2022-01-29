<template>
    <div class="card m-1 m-xl-3 stage">
        <h5  class="mx-3 mt-3 text-muted">
            {{ board.title }}
            <span class="badge p-1" v-text="board.tasks.length"/>
            <button @click="destroy" class="float-end btn btn-outline-danger btn-circle">
                <i class="fal fa-trash"></i>
            </button>
            <button @click="createTask(board)" class="float-end btn btn-outline-primary btn-circle mx-2">
                <i class="fal fa-plus"></i>
            </button>
        </h5>
        <div class="card-body pt-0 task-container">
            <Container group-name="tasks" @drop="onTaskDrop(board.id, $event)" :get-child-payload="getTaskPayload(board.id)">
                <Draggable v-for="task in tasks" :key="task.id">
                    <task :task="task"/>
                </Draggable>
                <div v-show="!(board.tasks.length > 0)" class="p-2 my-3 rounded m-0 text-center" style="border: #0a53be 1px dashed">
                    <small class="d-block text-muted text-uppercase" v-text="'drag any task'"/>
                </div>
            </Container>
<!--            <button @click="createTask(board.id)" v-text="'+ Add task'" class="col-12 my-2 py-2 btn btn-outline-primary" />-->
        </div>
    </div>
</template>

<script>
    import {Container, Draggable} from "vue3-smooth-dnd";
    import Task from "./Task";
    import {applyDrag} from "../utils/helpers";
    import { mapActions } from 'vuex'

    export default {
        components: {
           Task, Container, Draggable
        },
        computed: {
            tasks(){
                return this.board.tasks.sort((a, b) => a.order - b.order)
            }
        },
        props: ['board'],
        methods: {
            ...mapActions(['updateBoard', 'deleteBoard', 'createTask', 'updateTask']),
            update(){
                this.updateBoard(this.board)
            },
            destroy(){
                if (confirm('Are u sure delete board?')) {
                    this.deleteBoard(this.board)
                }
            },
            getTaskPayload (id) {
                return index => {
                    return this.$store.getters.getBoardById(id).tasks[index]
                }
            },
            onTaskDrop (boardId, dropResult) {
                const {removedIndex, addedIndex, payload} = dropResult
                if (removedIndex !== null || addedIndex !== null){
                    this.$store.getters.getBoardById(boardId).tasks = applyDrag(
                        this.$store.getters.getBoardById(boardId).tasks,
                        dropResult
                    )
                    if (removedIndex !== addedIndex && addedIndex !== null) {
                        payload.board_id = boardId
                        payload.order = addedIndex + 1
                        this.updateTask(payload)
                    }
                }
            },
        }
    }
</script>
