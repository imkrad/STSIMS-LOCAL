<template>
    <b-modal v-model="showModal" hide-footer class="v-modal-custom" modal-class="zoomIn" centered>
        <div class="modal-body text-center">
            <div class="mb-3 mt-n4">
                <i class="ri-error-warning-fill text-danger" style="font-size: 40px;"></i>
            </div>
            <div class="">
                <!-- <h4 class="mb-3">Are you sure you want to update it?</h4> -->
                <p v-if="option == 1" class="mb-2 fs-13">Hide <span class="fw-semibold text-success">{{name}}</span> from the list of termination</p>
                <p v-if="option == 2" class="mb-2 fs-13">Mark <span class="fw-semibold text-success">{{name}}</span> status as suspended</p>
                <p v-if="option == 3" class="mb-2 fs-13">Are you sure you want to terminate <br /><span class="fw-semibold text-success">{{name}}</span>?</p>
                <p class="text-muted fs-11 mb-4">This will update the released benefit status of the scholars. Please do it regularly to monitor the scholars correctly and update their benefit status.</p>
                <div class="hstack gap-2 justify-content-center mt-4">
                    <button @click="confirm()" :disabled="form.processing" class="btn btn-primary">Confirm Now</button>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            currentUrl: window.location.origin,
            showModal: false,
            option: '',
            name: '',
            form: {}
        }
    },
    methods: {
        show(option,name) {
            this.option = option;
            this.name = name;
            this.showModal = true;
        },
        confirm(){
            this.form.processing = true;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
