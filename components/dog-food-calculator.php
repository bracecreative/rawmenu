<section class="dog-food-calculator">
    <div class="background-top-images">
        <div class="image-one">
            <img src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-02.svg' ?>" alt="Dog-paw svg">
            <h4 class="title">Best affordable organic pet food</h4>
        </div>
    </div>
    <form action="" class="foodCalc form" onsubmit="return false">
        <h4 class="foodCalc-title">Select your type of dog</h4>
        <div class="form-fieldset-select">
            <div class="form-fieldset foodCalc-fieldset">
                <div class="foodCalc-select">
                    <input type="radio" class="form-radio" name="foodCalc-select" id="foodCalc-select-puppy"
                        value="puppy" checked>
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label for="foodCalc-select-puppy">Puppy</label>
                    </div>
                </div>
                <div class="foodCalc-select">
                    <input type="radio" class="form-radio" name="foodCalc-select" id="foodCalc-select-adultDog"
                        value="adultDog">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label for="foodCalc-select-adultDog">Adult Dog</label>
                    </div>
                </div>
                <div class="foodCalc-select">
                    <input type="radio" class="form-radio" name="foodCalc-select" id="foodCalc-select-workingDog"
                        value="workingDog">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label for="foodCalc-select-workingDog">Working Dog
                        </label>
                    </div>
                </div>
            </div>
            <div class="foodCalc-inputs-options">
                <div class="foodCalc-input">
                    <label for="foodCalc-weight">Enter the weight of your dog in kg</label>
                    <input type="number" class="form-input" name="foodCalc-weight" min="0" id="foodCalc-weight">
                </div>
                <div class="foodCalc-input" id="foodCalc-input--age">
                    <label for="foodCalc-age">Enter the age of your dog in months</label>
                    <input type="number" class="form-input" name="foodCalc-age" min="0" id="foodCalc-age">
                </div>
            </div>
        </div>
        <div class="foodCalc-input-results">
            <div class="foodCalc-input">
                <div>Recommended amount to feed per day:</div>
                <div class="foodCalc-result" id="foodCalc-result">3150 grams</div>
            </div>
            <p id="foodCalc-perDayPrice">
            <p class="">Based on the food selection of <b>Marrow Bones Knuckles Pk2</b> and the values entered in the
                calculator above, the average cost to feed your dog will be <b>£ 3.40 per day.</b><sup>*</sup>
            </p>
            </p>
        </div>
    </form>
    <div class="background-bottom-images">
        <img class="image-one" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Dog-in-heart-RM.svg' ?>"
            alt="Dog-in-heart svg">
        <img class="image-two" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-08.svg' ?>"
            alt="Dog-paw svg">
        <img class="image-three" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-03.svg' ?>"
            alt="Dog-paw svg">
        <img class="image-four" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-09.svg' ?>"
            alt="Dog-paw svg">
    </div>
</section>