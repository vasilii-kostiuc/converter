/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import 'bootstrap';

import axios from 'axios';

import Vue from 'vue';


var converter = new Vue({
    el: '#converter-app',
    data: {
        message: 'Вы загрузили эту страницу: ' + new Date().toLocaleString(),
        from: 0,
        to: 0,
        currency_from: 'USD',
        currency_to: 'USD',
        date: '',
        currencyRatesMap: []
    },
    created: function () {
        axios
            .get('/currencies_map')
            .then(response => {
                this.currencyRatesMap = response.data;
            });

    },
    watch: {
        from: function (newFrom, oldFrom) {
            this.convert();
        },
        currency_from: function (newFrom, oldFrom) {
            this.convert();
        },
        currency_to: function (newFrom, oldFrom) {
            this.convert();
        }
    },

    methods: {
        convert: function () {
            if (this.currency_from == this.currency_to) {
                this.to = this.from;
            } else {
                this.to = (this.from * this.currencyRatesMap[this.currency_from][this.currency_to]['value']).toFixed(2);
                this.date = this.currencyRatesMap[this.currency_from][this.currency_to]['date'];
            }
        }
    }
});