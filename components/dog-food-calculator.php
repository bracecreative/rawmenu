<section class="dog-food-calculator">
    <div class="background-top-images">
        <img class="image-one" src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-02.svg' ?>"
            alt="Dog-paw svg">
    </div>
    <form action="" class="foodCalc form" onsubmit="return false">
        <h4 class="foodCalc-title">Select your type of dog</h4>
        <div class="form-fieldset-select">
            <div class="form-fieldset foodCalc-fieldset">
                <button id="selected-dog-puppy" class="foodCalc-select">
                    <input type="radio" class="form-radio" name="foodCalc-select" value="puppy" checked
                        id="foodCalc-select-puppy">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label for="foodCalc-select-puppy">Puppy</label>
                    </div>
                </button>
                <button id="selected-dog-adultDog" class="foodCalc-select">
                    <input type="radio" class="form-radio" name="foodCalc-select" value="adultDog"
                        id="foodCalc-select-adultDog">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label for="foodCalc-select-adultDog">Adult Dog</label>
                    </div>
                </button>
                <button id="selected-dog-workingDog" class="foodCalc-select">
                    <input type="radio" class="form-radio" name="foodCalc-select" value="workingDog"
                        id="foodCalc-select-workingDog">
                    <div class="foodCalc-label">
                        <img class="dog-bone"
                            src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/svg/Assets%20RM-01.svg' ?>"
                            alt="Dog-bone svg">
                        <label for="foodCalc-select-workingDog">Working Dog</label>
                    </div>
                </button>
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
                <div class="foodCalc-result" id="foodCalc-result"></div>
            </div>
            <p id="foodCalc-perDayPrice">
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