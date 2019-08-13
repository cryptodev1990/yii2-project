<!--
  - Created by Artyom Manchenkov
  - artyom@manchenkoff.me
  - manchenkoff.me © 2019
  -->

<template>
    <div class="container">
        <div class="text-center m-4">
            <h2>{{ word }}</h2>
        </div>
        <button class="btn btn-success" :class="{'loading': word === '...'}" @click="loadText">
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

<style>
</style>