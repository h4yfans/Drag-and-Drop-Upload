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

    .list-inline{
        list-style: none;
        padding:0;
        margin:0;
    }

    .list-inline__item{
        display: inline;
        margin-right:20px;
    }

    .list-inline__item--last{
        margin-right: 0;
    }

</style>