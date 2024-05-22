<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Create Prospectus" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <div>
                        <h6 class="mb-1">Prospectus</h6>
                        <p class="text-muted fs-11 mt-n1">A curriculum-focused prospectus details the academic programs offered.</p>
                    </div>
                    <div>
                        <BRow class="g-3">
                            <BCol lg="12"><hr class="text-muted mt-n1 mb-n4"/></BCol>
                            <BCol lg="12" class="mt-1 mb-n3">
                                <InputLabel for="name" value="School Year" :message="form.errors.school_year"/>
                                <TextInput id="name" v-model="form.school_year" type="text" class="form-control" autofocus placeholder="Please enter prospectus school year" autocomplete="name" required :class="{ 'is-invalid': form.errors.school_year }" @input="handleInput('school_year')" :light="true"/>
                            </BCol>
                            <BCol lg="12"><hr class="text-muted mt-3 mb-2"/></BCol>
                        </BRow>
                    </div>    
                </BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Textarea },
    props: ['term'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                school_year: null,
                school_course_id : null,
                years: null,
                term: this.term,
                type: 'prospectus'
            }),
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.form.school_course_id = data.id;
            this.form.years = data.years;
            this.showModal = true;
        },
        submit(){
            this.form.post('/schools',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>