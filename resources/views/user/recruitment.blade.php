<x-user>
    <br> <br> <br>
    <!-- Contact Section -->
    <section id="contact" class="contact section bg-transparent">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Recruitments</h2>
            <p>Join the CENTRAL SUSHI team!</p>
        </div><!-- End Section Title -->



        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-4">


                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>{{ __('sentence.email') }} {{ __('sentence.us') }}</h3>
                            <p>{{ Settings::setting('site.email') }}</p>
                        </div>
                    </div><!-- End Info Item -->
                </div>

                <div class="col-lg-8">
                    <form action="{{ route('recrutment.mail') }}" method="post" class="php-email-form"
                        data-aos="fade-up" data-aos-delay="200" enctype="multipart/form-data">
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


                            <div class="col-md-6">
                                <select class="form-select form-select mb-3 bg-transparent text-colour"
                                    style="border: 1px solid var(--accent-color);" name="terget_position">
                                    <option selected>Target position </option>
                                    <option value="Versatile delivery person">Versatile delivery person</option>
                                    <option value="Multipurpose server">Multipurpose server</option>
                                    <option value="Kitchen assistant">Kitchen assistant</option>
                                    <option value="Chef Sushi">Chef Sushi</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select form-select mb-3 bg-transparent text-colour"
                                    style="border: 1px solid var(--accent-color);" name="city">
                                    <option selected>City</option>
                                    <option value="dijon">Dijon</option>
                                    <option value="besancon">Besancon</option>
                                    <option value="belfort">Belfort</option>
                                </select>
                            </div>

                            <div class="col-md-12 ">
                                <div class="custom-file">
                                    <input type="file" id="fileInput" name="cv_file"
                                        class="form-control bg-transparent" style="display: none;"
                                        accept="application/pdf">
                                    <label for="fileInput"
                                        style="
                                        border: 1px solid var(--accent-color); 
                                        background-color: var(--accent-color); 
                                        color: white; 
                                        padding: 5px 10px; 
                                        cursor: pointer; 
                                        border-radius: 5px;
                                    ">
                                        Submit Your CV
                                    </label>

                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="d-xl-block user-logout-button mt-3">Submit</button>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->
</x-user>