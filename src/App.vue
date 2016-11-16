<template>
    <div id="app">
        <upload-form></upload-form>
    </div>
</template>

<script>
import UploadForm from './components/UploadForm'

export default {
  name: 'app',
  components: {
    UploadForm
  }
}


</script>

<style>
    body{
        font-family: Arial, sans-serif;
    }

</style>