<template>
    <div class="card m-1 m-xl-3 stage">
        <h5 class="mx-3 mt-3 text-muted">
            <input v-show="showField('title')"
                   :id="'board_title' + board.id"
                   v-model="board.title"
                   class="field-value form-control"
                   type="text"
                   @blur="blurField"
                   @focus="focusField('title')">
            <div v-show="!showField('title')">
                <label :for="'board_title' + board.id" @click="focusField('title')" v-text="board.title"/>
                <span  class="badge p-1 m-2" v-text="board.tasks.length"/>
                <button class="float-end btn btn-outline-danger btn-circle" @click="destroy">
                    <i class="fal fa-trash"></i>
                </button>
                <button class="float-end btn btn-outline-primary btn-circle mx-2" @click="createTask(board)">
                    <i class="fal fa-plus"></i>
                </button>
            </div>
        </h5>
        <div class="card-body pt-0 task-container">
            <Container :get-child-payload="getTaskPayload(board.id)" group-name="tasks"
                       @drop="onTaskDrop(board.id, $event)">
                <Draggable v-for="task in tasks" :key="task.id">
                    <task :task="task"/>
                </Draggable>
                <div v-show="!(board.tasks.length > 0)" class="p-2 my-3 rounded m-0 text-center"
                     style="border: #0a53be 1px dashed">
                    <small class="d-block text-muted text-uppercase" v-text="'drag any task'"/>
                </div>
            </Container>
            <button class="col-12 my-2 py-2 btn btn-outline-primary" @click="createTask(board)" v-text="'+ Add task'"/>
        </div>
    </div>
</template>

<script>
import {Container, Draggable} from "vue3-smooth-dnd";
import Task from "./Task";
import {applyDrag} from "../utils/helpers";
import {mapActions} from 'vuex'

export default {
    components: {
        Task, Container, Draggable
    },
    data() {
        return {
            editField: '',
        }
    },
    computed: {
        tasks() {
            return this.board.tasks.sort((a, b) => a.order - b.order)
        }
    },
    props: ['board'],
    methods: {
        ...mapActions(['updateBoard', 'deleteBoard', 'createTask', 'updateTask']),
        focusField(field) {
            this.editField = field;
        },
        blurField() {
            this.editField = '';
            this.updateBoard(this.board)
        },
        showField(field) {
            return (this.board[field] === '' || this.editField === field)
        },
        destroy() {
            if (confirm('Are u sure delete board?')) {
                this.deleteBoard(this.board)
            }
        },
        getTaskPayload(id) {
            return index => {
                return this.$store.getters.getBoardById(id).tasks[index]
            }
        },
        onTaskDrop(boardId, dropResult) {
            const {removedIndex, addedIndex, payload} = dropResult
            if (removedIndex !== null || addedIndex !== null) {
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
