<template>
    <AppLayout title="Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <button
                        class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-3"
                        @click="openForm()">
                        Create
                    </button>

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.props.flash.message }}</p>
                            </div>
                        </div>
                    </div>

                    <table class="table-fixed w-full posts-table">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Image</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data.data" :key="item.id">
                                <td class="px-4 py-2 w-20">{{ item.id }}</td>
                                <td class="px-4 py-2">{{ item.title }}</td>
                                <td class="px-4 py-2">{{ item.author }}</td>
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-2">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        @click="openForm(item)"
                                    >Edit</button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        @click="deleteItem(item)"
                                        >Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <pagination :links="data.links"></pagination>
                    <book-form
                        :isOpen="isFormOpen"
                        :isEdit="isFormEdit"
                        :form="form"
                        @formsave="saveItem"
                        @formclose="closeModal"
                        >
                    </book-form>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script>
const defaultFormObject = {
        title: null, author: null, image: null
    };

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import BookForm from '@/Components/Book/Form.vue';


export default {
    components: {
      AppLayout,
      Pagination,
      BookForm
    },
    props: {
      data: Object,
    },
    data() {
        return {
            isFormOpen: false,
            isFormEdit: false,
            form: defaultFormObject
        }
    },
    methods: {
        saveItem(item) {
            console.log('salvando item >> ', item)

            let url = '/books';
            if(item.id){
                url = '/books/' + item.id;
                item._method = 'PUT';

                console.log('item aqui > ', item);
            }
            this.$inertia.post(url, item, {
                onError: () => {
                },
                onSuccess: () => {
                    this.closeModal();
                }
            });
        },
        closeModal() {
            this.isFormOpen = false;
        },
        openForm(item) {
            this.isFormOpen = true;
            this.isFormEdit = !!item;
            this.form = item ? item : defaultFormObject
            this.$page.props.errors = {}
        },
        deleteItem(item) {
            console.log('deletando item ::: ', item)

            if (window.confirm('Tem certeza???')) {
                this.$inertia.post('/books/' + item.id, {
                    _method: 'DELETE'
                });
            }
        }
    }
  }


</script>
