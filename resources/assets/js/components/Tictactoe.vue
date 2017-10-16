<template>
    <div id="tic-tac-toe">
        {{ title }}
        <div class="mdl-grid" v-for="(row, y) in grid">
            <div class="cell mdl-cell mdl-cell--4-col" v-for="(cell, x) in row" v-on:click="play(x, y)">{{ cell }}</div>
        </div>
        <a href="#" v-on:click="reset">reset</a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                grid: grid,
                title: 'Hi!',
            }
        },
        methods: {
            play: function (x, y) {
                this.grid[y][x] = 'X';
                this.title = x + '-' + y;
                this.submit('post', '/api/play');
            },

            submit: function (requestType, url) {
                Event.fire('progress-bar--show', true);
                Vue.prototype.$http[requestType](url, {grid: this.grid})
                    .then(response => {
                        this.grid = response.data.grid; 
                        Event.fire('progress-bar--show', false);
                    })
                    .catch(error => {
                        Event.fire('progress-bar--show', false);      
                    });
            },

            reset: function() {
                this.grid = [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ];
                this.title = 'Hi!';
            }
        }
    }
</script>

<style>

    #tic-tac-toe {
        padding: 30px;
    }

    .cell {
        background-color: #fdfdfd;
        border: 5px solid #cccccc;
        padding: 30px;
        height: 90px;
    }
</style>