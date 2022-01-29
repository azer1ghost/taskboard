<template>
    <div>
        <div class="row justify-content-between mt-4">
            <div class="col-3">
                <h2>
                    <strong>
                        Task board
                    </strong>
                </h2>
            </div>
            <div class="col-3">
                <button @click="createBoard" class="btn btn-outline-success float-end">Add Board</button>
            </div>
            <div v-show="loading" class="col-12 text-center text-muted">
                <h4>Fetching data <i class="fa fa-spin fa-spinner"></i></h4>
            </div>
            <div v-show="error.message" class="col-12 text-center text-muted">
                <div class="alert alert-danger" role="alert">
                    {{ error.message + ' (' + error.response.data.message + ')' }}
                </div>
            </div>
        </div>
        <Container
            class="d-flex flex-row flex-nowrap overflow-auto"
            group-name="boards"
            tag="div"
            orientation="horizontal"
            :get-child-payload="getBoardPayload()"
            @drop="onBoardDrop($event)">
            <Draggable v-for="board  in boards" :key="board.id" tag="div" class="col-12 col-sm-6 col-md-4 col-xl-3 mt-5 mt-md-0">
                <board :board="board" />
            </Draggable>
        </Container>
    </div>
</template>

<script>
    import { Container, Draggable } from "vue3-smooth-dnd";
    import { mapActions, mapState } from 'vuex'
    import { applyDrag } from "../utils/helpers";
    import Task from './Task';
    import Board from "./Board";

    export default {
            components: {
                Board, Task, Container, Draggable
            },
            methods: {
                ...mapActions(['fetchData', 'createBoard', 'updateBoard']),
                onBoardDrop(dropResult){
                    const {removedIndex, addedIndex, payload} = dropResult
                    if (removedIndex !== addedIndex && addedIndex !== null) {
                        this.$store.state.boards = applyDrag(this.$store.state.boards, dropResult)
                        payload.order = addedIndex + 1
                        this.updateBoard(payload)
                    }
                },
                getBoardPayload () {
                    return index => {
                        return this.boards[index]
                    }
                },
            },
            computed: {
                boards(){
                    return this.boards.sort((a, b) => a.order - b.order)
                },
                ...mapState(['boards', 'loading', 'error']),
            },
            created() {
               this.fetchData()
            }
        }
</script>

<style>
    .smooth-dnd-container.horizontal{
        display: flex !important;
    }
</style>
