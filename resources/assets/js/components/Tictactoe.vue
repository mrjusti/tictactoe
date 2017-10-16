<template>
    <div id="tic-tac-toe">
        <div class="flex-container">{{ title }}</div>
        <div class="flex-center">
            <div style="width:300px;">
                <div class="flex-container" v-for="(row, y) in grid">
                    <div class="flex-item" v-for="(cell, x) in row" v-on:click="play(x, y)">
                        <i class="material-icons mdl-color-text--green" v-if="cell == 'X'">face</i>
                        <i class="material-icons mdl-color-text--red" v-else-if="cell == 'O'">computer</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-center" style="margin-bottom:20px;">
            <button class="please mdl-button mdl-js-button mdl-button--raised" v-on:click="please">bot starts!</button>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" v-on:click="reset">reset</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                grid: grid,
                title: 'Hi!',
                state: 1,
            }
        },
        methods: {
            play: function (x, y) {
                if (this.state == 1 && this.grid[y][x] == '') {
                    this.grid[y][x] = 'X';
                    this.title = '...';
                    this.submit('post', '/api/play');    
                }
            },

            submit: function (requestType, url) {
                Event.fire('progress-bar--show', true);
                Vue.prototype.$http[requestType](url, {grid: this.grid})
                    .then(response => {
                        this.grid = response.data.grid;
                        this.state = response.data.status;
                        switch(response.data.status) {
                            case 1:
                                this.title = 'Still running.';
                                break;
                            case 2:
                                this.title = 'It\'s a draw, it\'s a draw.';
                                break;
                            case 3:
                                this.title = 'You lose!';
                                break;
                            case 4:
                                this.title = 'You win!';
                                break;
                        }
                        Event.fire('progress-bar--show', false);
                    })
                    .catch(error => {
                        Event.fire('progress-bar--show', false);      
                    });
            },

            please: function() {
                let grid = [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ];
                grid[this.random(0,2)][this.random(0,2)] = 'O';
                this.grid = grid;
                this.title = 'Still running.';
                this.state = 1;
            },

            random: function(min, max) {
                return Math.floor(Math.random() * ((max + 1) - min) + min);
            },

            reset: function() {
                this.grid = [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ];
                this.title = 'Hi!';
                this.state = 1;
            }
        }
    }
</script>

<style>



    .mdl-button {
        margin-top: 40px;
    }

    .please {
        margin-right: 10px;
    }

    .mdl-grid {
        padding: 0;
    }

    .flex-container {
        padding: 0;
        margin: 0;
        list-style: none;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-flow: row;
        justify-content: space-around;
    }
    .flex-item {
        background: rgba(158,158,158, 0.20);
        margin: 5px;
        color: white;
        text-align: center;
        flex: 1 0 auto;
        height:70px;
        width: 70px;
        line-height: 80px;
        cursor: pointer;
    }
    .flex-item:before {
        content:'';
        float:left;
        padding-top:100%;
    }
</style>