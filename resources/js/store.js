import {createStore} from 'vuex'

export const store = createStore({
    state() {
        return {
            boards: [], loading: true, error: {
                message: null, response: {
                    data: {
                        message: null
                    }
                }
            }
        }
    }, mutations: {
        startLoading() {
            this.state.loading = true
        }, stopLoading() {
            this.state.loading = false
        }
    }, getters: {
        getBoardById: (state) => (id) => {
            return state.boards.find(b => b.id === id);
        }, getBoardIndexById: (state) => (id) => {
            return state.boards.map(b => b.id).indexOf(id)
        }
    }, actions: {
        fetchData(context) {
            context.commit('startLoading')
            axios
                .get('boards')
                .then(response => {
                    this.state.boards = response.data.sort((a, b) => a.order - b.order)
                })
                .catch(error => {
                    this.state.error = error
                })
                .finally(() => {
                    context.commit('stopLoading')
                })
        }, createBoard(context) {
            axios
                .post(`boards`, {
                    title: "New Board",
                })
                .then(response => {
                    context.state.boards.unshift(response.data)
                })
                .catch((error) => context.state.error = error)
        }, updateBoard(context, board) {
            axios
                .put(`boards/${board.id}`, board)
                .then(function () {
                    // success
                })
                .catch((error) => context.state.error = error)
        }, deleteBoard(context, board) {
            axios
                .delete(`boards/${board.id}`)
                .then(function (response) {
                    context.state.boards.splice(context.getters.getBoardIndexById(board.id), 1)
                })
                .catch((error) => context.state.error = error)
        }, createTask(context, board) {
            axios
                .post(`tasks`, {
                    title: "New Task", detail: '', board_id: board.id
                })
                .then(response => board.tasks.unshift(response.data))
                .catch(error => context.state.error = error)
        }, updateTask(context, task) {
            axios
                .put(`tasks/${task.id}`, task)
                .then(function () {
                    //success
                })
                .catch((error) => context.state.error = error)
        }, deleteTask(context, task) {
            axios
                .delete(`tasks/${task.id}`)
                .then(function () {
                    let tasks = context.getters.getBoardById(task.board_id).tasks
                    let i = tasks.map(item => item.id).indexOf(task.id)
                    tasks.splice(i, 1)
                })
                .catch((error) => context.state.error = error)
        },
    }
})
