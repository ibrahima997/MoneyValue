<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <div class="row">
                      <div class="col-9">
                        <h3>Simple Currency Converter</h3>
                      </div>
                      <div class="col-3">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="add_currency_modal">manage currencies</button>
                      </div>
                    </div> 
                  </div>
                    <div class="card-body">

                      <form>
                        <label for="currency_from">Convert FROM</label>
                        <input id="currency_from" class="form-control" v-model="currency_from" @change="searchRatio()" name="currency_from">
                          <option v-for="currency in currencies" :value="currency.id">{{ currency.name }}</option>
                        <label for="currency_to">Convert TO</label>
                        <input id="currency_to" class="form-control" v-model="currency_to" @change="searchRatio()" name="currency_to">
                          <option v-for="currency in currencies" :value="currency.id">{{ currency.name }}</option>
                        <label for="amount">Amount</label>
                        <input id="amount" class="form-control" v-model="amount" @change="searchRatio()" name="amount">
                        
                       <button type="button" class="btn btn-primary btn-sm" @click="searchRatio()">Convert</button>
                      
                        </form>
                        
                    </div> 

                  

                </div> 
            </div> 
        </div> 

        <div class="modal fade" id="add_currency_modal" tabindex="-1" role="dialog" aria-labelledby="add_currency_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="add_currency_modal_label">Manage Currencies</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <table class="table">
                <tr v-for="currency in currencies">
                  <td>{{ currency.name}}</td>
                  <td>
                    <form>
                      <input type="hidden" name="to_be_deleted" v-bind:value="currency.id">
                      <button class="btn btn-sm btn-danger" type="button" name="delete_currency" v-on:click="deleteCurrency(currency.id)">delete</button>
                    </form>
                  </td>
                </tr>
              </table>
            </div>

            <div class="modal-footer">
              <form >
                <div class="row">
                  <div class="col">
                    <input type="text" name="new_currency" v-model="new_currency" placeholder="enter a new currency" class="form-control" required="required">
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-primary" v-on:click="addCurrency">add as new currency</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

    </div> 
</template>

<script>
    export default {
        data: function() {
          return {
            currencies: '',
            currency_from: '',
            currency_to: '',
            new_currency: '',
            currencies_not_same: false,
            ratio: '',
            amount: 1,
            results: '',
            ratio_changed: false,
            message: ''
          }
        },
        computed: {
          returnAbs: function() {
            return Math.abs(this.amount)
          }
        },
        methods: {
          ratioChanged: function() {
            if (this.ratio != null || this.radio != '') {
              this.ratio_changed = true;
            } else {
              this.ratio == false;
            }
          },
            currenciesNotSame: function() {
              if (this.currency_from == this.currency_to) {
                this.currencies_not_same = false;
              } else {
                this.currencies_not_same = true;
              }
            },
              resetProperties: function() {
                this.results = '';
                this.ratio = '';
                this.ratio_changed = false;
                this.currenciesNotSame();
              },
          currenciesList: function() {
            axios.get('/currencies')
            .then((res) => {
              this.currencies = res.data;
            }).catch((err) => {
              this.message = err.message;
            });
          },
          searchRatio: function() {
            if (this.currency_from != '' && this.currency_to != '') {
              if (this.currency_from == this.currency_to) {
                this.message = 'A currency cannot be converted to itself. Please select a different pair of currencies.'
                this.resetProperties();
              } else {
                this.currencies_not_same = true;
                axios.post('/ratios', {
                    currency_from: this.currency_from,
                    currency_to: this.currency_to,
                  })
                  .then((res) => {
                    this.ratio = res.data.ratio;
                    if (this.ratio == null || this.ratio == '') {
                      this.message = 'There is no default ratio for the current pair of currencies. Please enter a default ratio.'
                      this.results = '';
                      } else {
                        let product = this.returnAbs * this.ratio;
                        this.results = product.toFixed(4);
                        this.ratio_changed = false;
                        this.message = '';
                    }
                  }).catch((err) => {
                    this.message = err.message;
                    this.resetProperties();
                  });
              }
            }
          },
          deleteCurrency: function(id) {
            axios.delete('/currencies/' + id)
            .then((res) => {
              this.message = 'Currency deleted';
            }).catch((err) => {
              this.message = err.message;
              this.resetProperties();
            });
            this.currenciesList();
          },
          setRatio: function() {
              axios.post('/ratios/set', {
                currency_from: this.currency_from,
                currency_to: this.currency_to,
                ratio: this.ratio
              }).then((res) => {
                this.message = 'Ratio set';
              }).catch((err) => {
                this.message = err.message;
                this.resetProperties();
              });
              let product = this.returnAbs * this.ratio;
              this.results = product.toFixed(4);
              this.ratio_changed = false;
          },
          addCurrency: function() {
            axios.post('/currencies', {
              name: this.new_currency
            }).then((res) => {
              this.message = 'Currency added';
            }).catch((err) => {
              this.message = err.message;
              this.resetProperties();
            });
            this.new_currency = '';
            this.currenciesList();
          }
        },
        mounted() {
          this.currenciesList();
        }
    }
</script>
