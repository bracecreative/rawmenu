<section class="dog-food-calculator">
    <div class="background-top-images">
        <img class="image-one" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-02.svg' ?>"
            alt="Dog-paw svg">
    </div>
    <form action="" class="foodCalc form" onsubmit="return false">
        <h4 class="foodCalc-title">Select your type of dog</h4>
        <div class="form-fieldset-select">
            <div class="form-fieldset foodCalc-fieldset">
                <button id="puppy" value="puppy" class="foodCalc-select">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label>Puppy</label>
                    </div>
                </button>
                <button id="adultDog" value="adultDog" class="foodCalc-select">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label>Adult Dog</label>
                    </div>
                </button>
                <button id="workingDog" value="workingDog" class="foodCalc-select">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label>Working Dog</label>
                    </div>
                </button>
            </div>
            <div class="foodCalc-inputs-options">
                <div class="foodCalc-input">
                    <label for="foodCalc-weight">Enter the weight of your dog in kg</label>
                    <input type="number" class="form-input" name="foodCalc-weight" min="0" id="dogWeightInput">
                </div>
                <div class="foodCalc-input" id="dogInputAgeOption">
                    <label for="foodCalc-age">Enter the age of your dog in months</label>
                    <input type="number" class="form-input" name="foodCalc-age" min="0" id="dogAgeInput">
                </div>
            </div>
        </div>
        <div class="foodCalc-input-results">
            <div class="foodCalc-input">
                <div>Recommended amount to feed per day:</div>
                <div class="foodCalc-result" id="finalResultRecommendation"></div>
            </div>
            <p id="finalResultPricePerDay">
            <p class="">
            </p>
            </p>
        </div>
    </form>
    <div class="background-bottom-images">
        <img class="image-one" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Dog-in-heart-RM.svg' ?>"
            alt="Dog-in-heart svg">
        <img class="image-two" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-08.svg' ?>"
            alt="Dog-paw svg">
        <img class="image-three" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-09.svg' ?>"
            alt="Dog-paw svg">
    </div>
</section>