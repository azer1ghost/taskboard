<template>
    <div class="shadow-sm p-2 my-3 bg-body rounded m-0 task-item">
        <div class="float-end">
            <i class="fal fa-trash-alt task-edit-btn text-danger me-2" @click="destroy"></i>
            <label v-show="!showField('detail')"
                   :for="'task_detail' + task.id"
                   @click="focusField('detail')">
                <i class="fal fa-pencil task-edit-btn"></i>
            </label>
        </div>
        <div class="task-title">
            <label v-show="!showField('title')"
                   :for="'task_title' + task.id"
                   @click="focusField('title')">
                <strong v-text="task.title"/>
            </label>
            <input v-show="showField('title')"
                   :id="'task_title' + task.id"
                   v-model="task.title"
                   class="field-value form-control" type="text"
                   @blur="blurField"
                   @focus="focusField('title')"/>
        </div>
        <small class="d-block text-muted text-uppercase">
            <i class="fal fa-file-alt"></i>
            description
        </small>
        <div class="task-description">
            <label v-show="!showField('detail')"
                   :for="'task_detail' + task.id"
                   @click="focusField('detail')"
                   v-text="task.detail">
            </label>
            <textarea v-show="showField('detail')"
                      :id="'task_detail' + task.id"
                      v-model="task.detail"
                      class="field-value form-control"
                      rows="5"
                      type="text"
                      @blur="blurField"
                      @focus="focusField('detail')"/>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    props: ['task'],
    data() {
        return {
            editField: '',
        }
    },
    methods: {
        ...mapActions(['updateTask', 'deleteTask']),
        focusField(field) {
            this.editField = field;
        },
        blurField() {
            this.editField = '';
            this.updateTask(this.task)
        },
        showField(field) {
            return (this.task[field] === '' || this.editField === field)
        },
        destroy() {
            if (confirm('Are u sure delete task?')) {
                this.deleteTask(this.task)
            }
        },
    }
}
</script>
