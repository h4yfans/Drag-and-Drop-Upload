<template>
    <div>
        <div class="dragndrop__status" v-if="files.length">
            <ul class="list-inline">
                <li class="list-inline__item">File: {{files.length}}</li>
                <li class="list-inline__item">Percentage: x%</li>
                <li class="list-inline__item list-inline__item--last">Time remaining: 00::00</li>
            </ul>
        </div>
    <file v-for="file in files" :file="file"></file>
    </div>
</template>

<script>
    import File from './File'
    export default{
        props: [
            'files'
        ],
        components: {
            File
        }
    }
</script>


<style scoped>
    .dragndrop__status{
        text-align: center;
        padding:20px;
    }
</style>