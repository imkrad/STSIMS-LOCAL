<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" hide-footer header-class="p-3 bg-light"  class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Download Scholars</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <b-form action="#" id="editform" class="tablelist-form" autocomplete="off">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="p-2">
                        <div class="text-center">

                            <div class="avatar-md mx-auto">
                                <div class="avatar-title rounded-circle bg-light">
                                    <i class="ri-download-cloud-2-fill h1 mb-0 text-primary"></i>
                                </div>
                            </div>
                            <div class="p-2 mt-4">
                                <form @submit.prevent="preview" enctype="multipart/form-data">
                                    <p v-if="!result" class="text-muted">Download all scholars from the central server. This is to avoid typographical error when populating the system.</p>
                                    <p v-else class="text-muted">Scholars was downloaded from central server.</p>
                                    <span v-if="isLoading"><i class='bx bx-loader-circle bx-spin mt-2'></i><span class="text-muted ms-1 mt-n4">Loading ... </span></span>
                                    <div class="alert alert-danger mb-xl-0" role="alert" v-if="oops"><strong>Something is wrong!</strong> Contact Administrator!</div>
                                    <div class="row g-0 text-center" v-if="result">
                                        <div class="col-sm-4">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span>{{success.length}}</span></h5>
                                                <p class="text-success fw-semibold mb-0">Success</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span>{{failed.length}}</span></h5>
                                                <p class="text-danger fw-semibold mb-0">Failed</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span>{{duplicate.length}}</span></h5>
                                                <p class="text-warning fw-semibold mb-0">Duplicate</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4" v-if="!hide2">
                                        <button @click="submit" type="button"  class="btn btn-primary w-lg">Download</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            success: [],
            failed: [],
            duplicate: [],
            isLoading: false,
            result: false,
            oops: false,
            hide2: false,
            showModal: false,
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        submit(){
            this.isLoading = true;
            this.hide2 = true;

            axios.post(this.currentUrl + '/scholars/lists', {
                option: 'api',
                type: 'download'
            })
            .then(response => {
                this.isLoading = false;
                this.result = true;
                this.success = response.data.success;
                this.failed = response.data.failed;
                this.duplicate = response.data.duplicate;
                this.$emit('info',true);
            })
            .catch(err => {
                this.isLoading = false;
                this.oops = true;
                console.log(err)
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>