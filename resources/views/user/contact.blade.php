<x-user>
    @push('css')
        <style>
            #map-nos {
                height: 500px;
                /* Set a height for the map */
                width: 100%;
            }
        </style>
    @endpush
    <br> <br> <br>
    <!-- Contact Section -->
    <section id="contact" class="contact section bg-transparent">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ __('sentence.contact') }}</h2>
            <p>{{ __('sentence.contact') }} {{ __('sentence.us') }}</p>
        </div><!-- End Section Title -->



        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                {{-- <div class="col-lg-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>{{ __('sentence.call') }} {{ __('sentence.us') }}</h3>
                            <p>{{ Settings::setting('site.phone') }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>{{ __('sentence.email') }} {{ __('sentence.us') }}</h3>
                            <p>{{ Settings::setting('site.phone') }}</p>
                        </div>
                    </div><!-- End Info Item -->
                </div> --}}

                <div class="">
                    {{-- <form action="{{route('contact.mail')}}" method="post" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name"
                                    required="">
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                            </div>
                        </div>
                        <button type="submit"
                        class="d-xl-block user-logout-button mt-3">Submit</button>
                    </form> --}}

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2704.535575207828!2d5.0314998!3d47.3234108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f29d94bd63fdcb%3A0x5c3d38bb2bb2ac71!2s25%20Pl.%20Darcy%2C%2021000%20Dijon%2C%20France!5e0!3m2!1sen!2sae!4v1709789861376!5m2!1sen!2sae"
                        width="1300" height="800" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>

                    {{-- <div id="map-nos"></div> --}}
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->

    @push('js')
        <script>
            function initMapNOS() {
                const locations = [{
                        lat: 47.323430,
                        lng: 5.031508
                    }, // New York City
                    {
                        lat: 47.245721,
                        lng: 6.028465
                    }, // Los Angeles
                    {
                        lat: 47.631816,
                        lng: 6.856420
                    } // London
                ];

                const map = new google.maps.Map(document.getElementById('map-nos'), {
                    zoom: 7,
                    center: locations[0]
                });

                locations.forEach((location) => {
                    new google.maps.Marker({
                        position: location,
                        map: map
                    });
                });
            }

            initMapNOS();
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMapNOS&v=weekly" async defer>
        </script>
    @endpush
</x-user>
