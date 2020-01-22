<template>
    <div class="uk-container">
        <div class="uk-text-center uk-margin">
            <h2>{{ word }}</h2>
        </div>
        <button class="uk-button uk-button-success uk-margin-large-top" :class="{'loading': word === '...'}" @click="loadText">
            Get Random Word
        </button>
    </div>
</template>

<script>
    import swal from 'sweetalert'
    import toast from '../services/toast'

    export default {
        data() {
            return {
                word: 'This is default text, try to load a new one!',
            }
        },
        methods: {
            loadText() {
                swal({
                    title: "Are you sure?",
                    text: "Don't worry! It's just an example of SweetAlert with Vue.js",
                    buttons: true
                }).then((value) => {
                    if (value) {
                        this.word = '...';

                        this.$http
                            .get('api/get-text')
                            .then((response) => {
                                this.word = response.data;

                                toast.success('Text was updated!');
                            })
                            .catch(() => {
                                this.word = 'Ooops! Something went wrong';

                                toast.error('Error notification example')
                            })
                    } else {
                        swal("As you wish...", {
                            icon: 'success'
                        });
                    }
                });
            },
        }
    }
</script>