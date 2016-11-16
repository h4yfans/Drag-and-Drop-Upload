<template>
    <div class="dragndrop"
         @dragover.prevent="enter"
         @dragenter.prevent="enter"
         @dragleave.prevent="leave"
         @dragend.prevent="leave" @drop.prevent="drop"
         v-bind:class="{ 'dragndrop--dragged' : isDraggedOver }">
        <input type="file" name="files[]" id="file" class="dragndrop__input" multiple v-on:change="select" ref="input">
        <label for="file" class="dragndrop__header dragndrop__header--compact">
            <strong>Drag files here</strong> or click to select files
        </label>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                files: [],
                isDraggedOver: false
            }
        },
        methods: {
            enter(){
                this.isDraggedOver = true
            },
            leave(){
                this.isDraggedOver = false
            },
            drop(e){
                this.leave();
                this.addFiles(e.dataTransfer.files);

            },
            select(e){
                this.addFiles(this.$refs.input.files)
            },
            addFiles(files){
                var i, file;

                for (i = 0; i < files.length; i++) {
                    file = files[i]

                    this.storeMeta(file).then((fileObject) => {
                        //upload
                        this.upload(fileObject)
                    }, (fileObject) => {
                        fileObject.failed = true
                    });
                }
            },
            upload(fileObject){
                var form = new FormData()

                form.append('file', fileObject.file)
                form.append('id', fileObject.id)


                // emit upload init

                this.$http.post('http://localhost:3030/vueupload/store.php', form, {
                    before: (xhr) => {
                        fileObject.xhr = xhr
                    },
                    progress: (e) => {
                        //emit progress
                        console.log(e.loaded)
                    }
                }).then((response) => {
                    //emit finished
                    console.log('finished')
                }, () => {
                    //emit failed
                })
            },
            storeMeta(file){
                var fileObject = this.generateFileObject(file);
                // create file object

                return new Promise((resolve, reject) => {
                    this.$http.post('http://localhost:3030/vueupload/store.php', {
                        name: file.name
                    }).then((response) => {
                        fileObject.id = response.body.data.id
                        resolve(fileObject)
                    }, () => {
                        reject(fileObject)
                    });
                })
            },
            generateFileObject(file){
                var fileObjectIndex = this.files.push({
                            id: null,
                            file: file,
                            progress: 0,
                            failed: false,
                            loadedBytes: 0,
                            totalBytes: 0,
                            timeStarted: (new Date).getTime(),
                            secondsRemaining: 0,
                            finished: false,
                            cancelled: false,
                            xhr: null

                        }) - 1

                return this.files[fileObjectIndex];
            }
        }
    }
</script>


<style scoped>
    .dragndrop {
        --dragndrop-min-height: 200px;
        width: 100%;
        min-height: var(--dragndrop-min-height);
        background-color: #f8f8f8;
        position: relative;
        border: 3px dashed rgba(0, 0, 0, .2);
    }

    .dragndrop--dragged {
        border-color: #333;
    }

    .dragndrop__input {
        display: none;
    }

    .dragndrop__header {
        display: block;
        font-size: 1.1em;
        color: #555;
        vertical-align: middle;
        text-align: center;
        margin: calc(var(--dragndrop-min-height) / 2) 20px;
    }

    .dragndrop__header:hover {
        text-decoration: underline;
        cursor: pointer;
    }

    .dragndrop__header--compact {
        margin: calc(var(--dragndrop-min-height) / 2) 20px;
    }
</style>
