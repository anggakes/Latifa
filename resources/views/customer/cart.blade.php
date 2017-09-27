@extends('customer/template')

@section('css')

@endsection


@section('content')


    <div class="card">
        <div class="card-header" style="color:#84c225"> #item:</div>
        <div class="card-block row" style="font-weight: bold">
            <div class="col-6" v-text="cart.item.name"></div>
            <div class="col-6" style="text-align: right" v-text="price"></div>
        </div>
    </div>

    <br>
    <div class="card">
        <div class="card-header" style="color:#84c225"> #jadwal:</div>
        <div class="card-block row " style="font-weight: bold;">

            <!--</div>-->
            <button v-if="cart.booking_date == undefined" type="button" data-toggle="modal" data-target="#bookingDateModal" class="btn btn-info" style="background: #e77817;margin:0px auto">Pilih Jadwal</button>

            <div v-else class="col">
                <div class="edit"><a href="#" data-toggle="modal" data-target="#bookingDateModal"><i class="oi oi-pencil" style="color:#fff;font-size: 8pt;" ></i></a></div>
                <span v-text="moment(cart.booking_date).format('LLL')" ></span>
            </div>
        </div>
    </div>

    <br>
    <div class="card">
        <div class="card-header" style="color:#84c225"> #lokasi:</div>
        <div class="card-block row text-center" style="font-weight: bold;text-align: center">
            <button v-if="cart.location == undefined " type="button" class="btn btn-info" style="background: #e77817;margin:0px auto" v-on:click="openLocation">Pilih Lokasi</button>

            <div v-else style="text-align: left;" class="col">
                <div class="edit"><a href="#" v-on:click="openLocation"><i class="oi oi-pencil" style="color:#fff;font-size: 8pt;" ></i></a></div>
                <span v-text="cart.location.label"></span><br>
                <span style="font-size: 8pt" v-text="cart.location.address"></span>
            </div>
        </div>
    </div>

    <br>
    <div class="card">
        <div class="card-header" style="color:#84c225"> #catatan:</div>
        <div class="card-block text-center" style="font-weight: bold;text-align: center">
            <textarea class="form-control" placeholder="Catatan untuk terapis" id="note"></textarea>
        </div>
    </div>

    <br>
    <div class="card">

        <div class="card-block row text-center" style="font-weight: bold;text-align: center">
            <table class="table">

                <tbody>
                <tr v-for="fees in cart.fees">
                    <th scope="row" v-text="fees.label"></th>
                    <td class="amount" v-text="currencyformat(fees.value,'Rp ')"></td>
                </tr>

                </tbody>
                <tfoot>
                <tr>
                    <th scope="row">TOTAL</th>
                    <td class="amount" v-text="currencyformat(cart.total,'Rp ')"></td>
                </tr>
                </tfoot>
            </table>

            <!--<div class="row">-->

            <div class="col-8">
                <input type="email" class="form-control"  aria-describedby="emailHelp" placeholder="Kode Voucher" v-model="voucher_code">
            </div>
            <div class="col-4" style="text-align: right">
                <button type="button" class="btn btn-info" style="background: #e77817;margin:0px auto" v-on:click="checkVoucher">CEK</button>
            </div>
            <div style="color: red;padding-left:5px;margin-top:10px;font-size: 8pt;background: #f9f9f9"> <span v-text="error_voucher"></span><br></div>

            <!--</div>-->
            <div style="margin-top: 10px" class="col-12 text-left">
                <input type="checkbox" v-model="toa"> <span style="font-size: 8pt">Saya menyetujui <a href="#"> syarat dan ketentuan</a></span>

            </div>

        </div>
    </div>

    <br><br><br>
    <button type="button" class="btn btn-primary " style="width: 100%;position: fixed;
    bottom: 0px;height: 49px;
    left: 0px;" v-bind:class="[ toa ? 'enabled-checkout' : 'disabled-checkout' ]" v-on:click ="checkout">CHECKOUT</button>


    <!-- Modal -->
    <div class="modal fade" id="bookingDateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jadwal</h5>
                </div>
                <div class="modal-body row">
                    <div class="col-6"><input type="radio" name="date" v-model="day" v-bind:value="today"> Hari ini</div>
                    <div class="col-6" style=""><input type="radio" name="date" v-model="day" v-bind:value="tomorrow"> Besok</div><br><br>
                    <div class="col">
                        <!--<label for="exampleInputEmail1">Email address</label>-->
                        <el-time-select v-model="time" :picker-options="{
                    start: '08:30',
                    step: '01:00',
                    end: '16:30'
                    }" placeholder="pilih waktu">
                        </el-time-select>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background:#c0c0c0">Batal</button>
                    <button type="button" v-on:click="setBookingDate()" class="btn btn-primary" style="background: #e77817;">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Set Lokasi</h5>
                </div>
                <div class="modal-body row">
                    <form id="formLocation" class="col" v-on:submit.prevent="setLocation">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Lat</label>
                            <input name="lat" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Lat">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Lng</label>
                            <input name="lng" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Lng">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input name="address" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Label</label>
                            <input name="label" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Label">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background:#c0c0c0">Batal</button>
                    <button type="button" v-on:click="setLocation()" class="btn btn-primary" style="background: #e77817;">Simpan</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script>
        var vue = '';


        var app = new Vue({
            el: '#app',
            data: {
                cart: {
                    item : {
                        name : '',
                        price : 0,
                        sale_price :0
                    },
                    fees : [],
                    total : 0,
                    location : {},
                    voucher : {}
                },
                time : '08:30',
                day: '',
                error_voucher :'',
                voucher_code :'',
                toa:true
            },
            store:store,
            mounted : function (){
                vue = this;
                moment.locale('id');

                this.refreshCart();

            },
            methods : {
                currencyformat : currencyformat,
                moment : moment,
                setBookingDate : function(){

                    date = this.day+' '+this.time+":00";

                    axios({
                        method: 'post',
                        data : {
                            booking_date : date
                        },
                        url: apiUrl+'/customer/cart/booking_date',
                        headers: headers

                    }).then(function (response) {

                        console.log(response.data.data);
                        vue.refreshCart();
                        $('#bookingDateModal').modal('hide')

                    });

                },
                refreshCart : function (){

                    axios({
                        method: 'get',
                        url: apiUrl+'/customer/cart',
                        headers: headers
                    }).then(response => {

                        this.cart = response.data.data;
                        if(response.data.data.voucher == null){
                            this.voucher_code = '';
                        }else{
                            this.voucher_code = response.data.data.voucher.voucher_code;
                        }
                    });
                },
                openLocation : function(){
                    if(isMobile){
                        window.location = rootDeeplink+'cart_location';
                    }else{
                        $('#locationModal').modal('show')
                    }
                },
                setLocation : function(){

                    data  = $( "#formLocation" ).serialize();

                    axios({
                        method: 'post',
                        data : data,
                        url: apiUrl+'/customer/cart/location',
                        headers: headers

                    }).then(function (response) {

                        console.log(response.data.data);
                        vue.refreshCart();
                        $('#locationModal').modal('hide')

                    }).catch(function (error) {
                        alert(error.data.message);
                        vue.refreshCart();
                        $('#locationModal').modal('hide')
                    });

                },
                checkout : function () {

                    var note = $('#note').val();

                    axios({
                        method: 'post',
                        data : {
                            note : note
                        },
                        url: apiUrl+'/customer/cart/checkout',
                        headers: headers

                    }).then(function (response) {

                        console.log(response.data.data);

                        if(isMobile){
                            window.location = rootDeeplink+response.data.data.redirectMobile;
                        }else{
                            window.location = baseUrl+response.data.data.redirectWeb;
                        }

                    }).catch(function (error) {
//                    console.log(error);
                        vue.error_voucher = error.data.message;
                        vue.refreshCart();
                    });

                },
                checkVoucher : function (){
                    voucher_code = vue.voucher_code;

                    if(vue.cart.voucher !=  undefined){
                        if( voucher_code == vue.cart.voucher.voucher_code){
                            return;
                        }
                    }

                    vue.error_voucher = '';
                    axios({
                        method: 'post',
                        data : {
                            voucher_code : voucher_code
                        },
                        url: apiUrl+'/customer/cart/voucher',
                        headers: headers

                    }).then(function (response) {

                        console.log(response.data.data);
                        vue.refreshCart();

                    }).catch(function (error) {
//                    console.log(error);
                        vue.error_voucher = error.data.message;
                        vue.refreshCart();
                    });
                }
            },
            computed: {

                price: function () {
                    price = parseInt(this.cart.item.price);
                    salePrice = parseInt(this.cart.item.sale_price);
                    if(salePrice > 0) return currencyformat(salePrice, "Rp ");

                    return currencyformat(price, "Rp ");
                },
                today : function(){
                    return moment().format('YYYY-MM-DD');
                },
                tomorrow : function(){
                    return moment().add(1,'days').format('YYYY-MM-DD');
                }
            }
        })
    </script>
@endsection