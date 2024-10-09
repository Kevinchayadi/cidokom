<template>
    <div>
      <button @click="showAlert">Show Sweet Alert</button>
    </div>
  </template>
  
  <script>
  import Swal from 'sweetalert2'
  
  export default {
    methods: {
      showAlert() {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        })
      }
    }
  }
  </script>