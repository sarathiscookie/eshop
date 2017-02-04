@extends('layouts.app')

@section('title', 'Welcome')

@section('styles')
    <link href="/css/nouislider/nouislider.min.css" rel="stylesheet">
    <style>
        .noUi-horizontal .noUi-handle-lower .noUi-tooltip {
            bottom: -32px !important;
            top:24px;
        }
        .thumbnail-custom {
            border: none;
            background-color: #f5f5f5;
            margin-bottom: 0px;
        }
    </style>
@endsection

@inject('showAvatar', 'App\Http\Controllers\WelcomeController')

@section('content')
    <div class="container">
        <div class="well">
            <div class="row" id="options">
                <h4>Title:</h4>
                <div class="col-md-2 option-set" data-group="gender">
                    <h5>Gender</h5>
                    <label>
                        <input type="checkbox" value=".m"> male
                    </label><br>
                    <label>
                        <input type="checkbox" value=".f"> female
                    </label><br>
                    <label>
                        <input type="checkbox" value=".n"> other
                    </label>
                </div>
                <div class="col-md-2 option-set" data-group="messenger">
                    {{--<h5>Group Messenger</h5>
                    @foreach($userObj->messengers as $filterKey =>$filterItem)
                        <label>
                            <input type="checkbox" value=".{{$filterKey}}"> {{  $filterItem }}
                        </label><br>
                    @endforeach--}}
                </div>
                <div class="col-md-4" data-group="age">
                    <h5>Age Group</h5>
                    <div id="age_slider"></div>
                </div>
                <div class="col-md-4 option-set" data-group="country">
                    <h5>Country</h5>
                    <select id="country" class="form-control">
                        <option value="" title="Choose Country">--Choose Country--</option>
                        {{--@foreach($countryList as $country)
                            <option value="{{ $country['id'] }}">{{ $country['country_name'] }}</option>
                        @endforeach--}}
                    </select>
                </div>
            </div>
            <div class="text-right"><button class="btn btn-success" type="button" id="resetFilterBtn">Reset</button></div>
        </div>

        <div id="msg-box" class="text-danger text-center">No results for current filter</div>

        <div class="grid" id="app">
            @if(isset($products))
                @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 grid-item {{ $product->name }}">
                        <div class="panel panel-default">
                            <div class="panel-body thumbnail thumbnail-custom">
                                <div class="row">
                                    <div class="col-md-7">
                                        {{ $product->created_at }}
                                    </div>
                                    <div class="col-md-5 text-right">age <span class="number">{{ $product->id }}</span>, {{ $product->name }}</div>
                                </div>
                                @if($showAvatar->show($product->id)!='') <img src="{{ url('/product/avatar/'.$product->id) }}" class="img-circle" alt="{{ $product->name }}" width="200"> @endif

                                <div class="caption">
                                    <h3 class="text-center"><strong>{{ $product->name }}</strong></h3>
                                    <p class="text-center">{{ $product->description }}</p>
                                    <p class="text-center">{{ $product->stock }}</p>
                                </div>
                            </div>
                            <div class="panel-footer" style="background-color:#31b0d5; min-height: 100px">
                                <div class="row" style="padding: 10px;">
                                    <div class="col-md-8">
                                        {{ $product->amount }}
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="#" role="button" class="btn btn-primary" target="_blank">
                                            Checkout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/isotope.pkgd.min.js"></script>
    <script src="/js/packery-mode.pkgd.min.js"></script>
    <script src="/js/nouislider/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.16/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>
    <script>
        $('#msg-box').hide();
        var $grid = $('.grid').isotope({
            // options
            itemSelector: '.grid-item',
            layoutMode: 'fitRows',
        });

        var filters = {};

        var data = {
            gender: 'm f n'.split(' '),
            messengers: 'skype kik threema snapchat'.split(' '),
        }
        var min = 16;
        var max = 70;

        // store filter for each group
        var comboFilter;
        $('#options').on( 'change', function( jQEvent ) {
            var $checkbox = $( jQEvent.target );
            manageCheckbox( $checkbox );

            comboFilter = getComboFilter( filters );

            $grid.isotope({ filter: multipleFilter });
            checkResults();
        });

        //Combination filter values
        function getComboFilter( filters ) {
            var i = 0;
            var comboFilters = [];
            var message = [];

            for ( var prop in filters ) {
                message.push( filters[ prop ].join(' ') );
                var filterGroup = filters[ prop ];
                // skip to next filter group if it doesn't have any values
                if ( !filterGroup.length ) {
                    continue;
                }
                if ( i === 0 ) {
                    // copy to new array
                    comboFilters = filterGroup.slice(0);
                } else {
                    var filterSelectors = [];
                    // copy to fresh array
                    var groupCombo = comboFilters.slice(0); // [ A, B ]
                    // merge filter Groups
                    for (var k=0, len3 = filterGroup.length; k < len3; k++) {
                        for (var j=0, len2 = groupCombo.length; j < len2; j++) {
                            filterSelectors.push( groupCombo[j] + filterGroup[k] ); // [ 1, 2 ]
                        }

                    }
                    // apply filter selectors to combo filters for next group
                    comboFilters = filterSelectors;
                }
                i++;
            }

            comboFilter = comboFilters.join(', ');
            return comboFilter;
        }

        //checkbox values and manage checked or not
        function manageCheckbox( $checkbox ) {
            var checkbox = $checkbox[0];

            var group = $checkbox.parents('.option-set').attr('data-group');
            // create array for filter group, if not there yet
            var filterGroup = filters[ group ];
            if ( !filterGroup ) {
                filterGroup = filters[ group ] = [];
            }

            var isAll = $checkbox.hasClass('all');
            // reset filter group if the all box was checked
            if ( isAll ) {
                delete filters[ group ];
                if ( !checkbox.checked ) {
                    checkbox.checked = 'checked';
                }
            }
            // index of
            var index = $.inArray( checkbox.value, filterGroup );

            if ( checkbox.checked ) {
                var selector = isAll ? 'input' : 'input.all';
                $checkbox.siblings( selector ).removeAttr('checked');


                if ( !isAll && index === -1 ) {
                    // add filter to group
                    filters[ group ].push( checkbox.value );
                }

            }
            else if(group=='country'){
                filters[group].splice(index, 1);
                if(checkbox.value!='') {
                    var str = '.region-' + checkbox.value;
                    filters[group].push( str )
                }
            }
            else if ( !isAll ) {
                // remove filter from group
                filters[ group ].splice( index, 1 );
                // if unchecked the last box, check the all
                if ( !$checkbox.siblings('[checked]').length ) {
                    $checkbox.siblings('input.all').attr('checked', 'checked');
                }
            }

        }

        //Age selection slider - noUiSlider
        var ageSlider = document.getElementById('age_slider');
        noUiSlider.create(ageSlider, {
            start: [ 16, 70 ],
            connect: true,
            tooltips: true,
            step: 1,
            range: {
                'min':   16 ,
                'max':  70
            },
            format: {
                to: function ( value ) {
                    return parseInt(value);
                },
                from: function ( value ) {
                    return parseInt(value);
                }
            }
        });

        // Age Filtering
        ageSlider.noUiSlider.on('slide', function(){
            var rangeVal = ageSlider.noUiSlider.get();
            min = rangeVal[0];
            max = rangeVal[1];

            $grid.isotope({ filter: multipleFilter   });
            checkResults();
        });

        //Handling multiple filter controls and  groups
        function multipleFilter() {
            var that = this;
            function checkAge() {
                var $number = $( that ).find('.number');
                var number = parseInt( $number.text(), 10 );
                return number >= min && number <= max;
            }

            return checkAge() && $(this).is(comboFilter || '*');
        }

        //Reset Filter
        $('#resetFilterBtn').click( function () {
            $('#options').find('input:checkbox').each( function () {
                $(this).prop('checked', false)
            });

            min = 16;
            max = 70;
            ageSlider.noUiSlider.set([16, 70]);
            $('#country').val('').trigger('change');

            filters     = {};
            comboFilter ='';
            $grid.isotope({ filter: '*'   });
            checkResults();
        });

        var checkResults = function () {
            if ($grid.data('isotope').filteredItems.length > 0) {
                $('#msg-box').fadeOut('fast');
            }
            else{
                $('#msg-box').fadeIn('slow');
            }
        };

       /* var socket = io('{{ env("APP_URL") }}:3000');
        socket.on('user-channel:App\\Events\\UserSignedUp', function(data){

            if(data.gender == "m"){
                var gender = 'male';
            }
            else if(data.gender == "f"){
                var gender = 'female';
            }
            else{
                var gender = 'other';
            }

            if(data.avatar_userid != ''){
                var avatar = '<img src="{{ url("/user/avatar/") }}/'+data.user_id+'" class="img-circle" alt="'+ data.nickname +'" width="200">'
            }
            // create new item elements
            var $items = $('<div class="col-sm-6 col-md-4 grid-item '+ data.gender +' '+ data.messengers +' region-'+ data.country_id +'"><div class="panel panel-default"> <div class="panel-body thumbnail thumbnail-custom"> <div class="row"> <div class="col-md-7"></div> <div class="col-md-5 text-right">age <span class="number">'+data.age+'</span>,  '+ gender +'  </div> </div> '+avatar+' <div class="caption"> <h3 class="text-center"><strong>'+ data.nickname +'</strong></h3> <p class="text-center">'+ data.description +'</p> <p class="text-center">'+data.userflag+'</p> </div> </div> <div class="panel-footer" style="background-color:#31b0d5; min-height: 246px"> '+data.showMessengers+' </div> </div> </div> </div>');
            // append items to grid
            $grid.append( $items )
                    // add and lay out newly appended items
                    .isotope( 'appended', $items );
        });*/

    </script>


@endsection