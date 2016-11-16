<template>
    <div>
        <div class="dragndrop__status" v-if="files.length">
            <ul class="list-inline">
                <li class="list-inline__item">File: {{files.length}}</li>
                <li class="list-inline__item">Percentage: {{overallProgress}}%</li>
                <li class="list-inline__item list-inline__item--last">Time remaining: 00::00</li>
            </ul>
        </div>
        <file v-for="file in files" :file="file"></file>
    </div>
</template>

<script>
    import File from './File'
    import eventHub from '../events.js'
    import timeremaining from '../helpers/timeremaining.js'
    export default{
        data(){
            return {
                overallProgress: 0,
                interval: null
            }
        },
        props: [
            'files'
        ],
        components: {
            File
        },
        methods: {
            unfinishedFile(){
                var i, files = []

                for (i = 0; i < this.files.length; i++) {
                    if (this.files[i].finished || this.files[i].cancelled) {
                        continue
                    }

                    files.push(this.files[i])
                }

                return files
            },
            updateOverallProgress(){
                var unfinishedFiles = this.unfinishedFile(), totalProgress = 0;
                //for each unfinished file
                //total progress 400%
                unfinishedFiles.forEach((file) => {
                    totalProgress += file.progress
                });
                this.overallProgress = parseInt(totalProgress / unfinishedFiles.length || 0)
                //total progress / unfinished file count
                //otherwise 0
            },
            updateTimeRemaining(){
                this.unfinishedFile().forEach((file) => {
                    file.secondsRemaining = timeremaining.calculate(
                            file.totalBytes,
                            file.loadedBytes,
                            file.timeStarted
                    );
                })
            }
        },
        mounted(){
            eventHub.$on('progress', (fileObject, e) => {
                this.updateOverallProgress()
            })

            eventHub.$on('init', () => {
                if (!this.interval) {
                    this.interval = setInterval(() => {
                        this.updateTimeRemaining()
                    }, 1000)
                }
            })
        }
    }
</script>


<style scoped>
    .dragndrop__status {
        text-align: center;
        padding: 20px;
    }
</style>