<section class="dog-food-calculator">
    <form action="" class="foodCalc form" onsubmit="return false">
        <h4 class="foodCalc-title">Select your type of dog</h4>
        <div class="form-fieldset foodCalc-fieldset">
            <div class="foodCalc-select">
                <input type="radio" class="form-radio" name="foodCalc-select" id="foodCalc-select-puppy" value="puppy"
                    checked>
                <div class="foodCalc-label"><i class="fas fa-bone"></i><label for="foodCalc-select-puppy">Puppy</label>
                </div>
            </div>
            <div class="foodCalc-select">
                <input type="radio" class="form-radio" name="foodCalc-select" id="foodCalc-select-adultDog"
                    value="adultDog">
                <div class="foodCalc-label"><i class="fas fa-bone"></i><label for="foodCalc-select-adultDog">Adult
                        Dog</label></div>
            </div>
            <div class="foodCalc-select">
                <input type="radio" class="form-radio" name="foodCalc-select" id="foodCalc-select-workingDog"
                    value="workingDog">
                <div class="foodCalc-label"><i class="fas fa-bone"></i><label for="foodCalc-select-workingDog">Working
                        Dog</label></div>
            </div>
        </div>
        <div class="foodCalc-input">
            <label for="foodCalc-weight">Enter the weight of your dog in kg</label>
            <input type="number" class="form-input" name="foodCalc-weight" min="0" id="foodCalc-weight">
        </div>
        <div class="foodCalc-input" id="foodCalc-input--age">
            <label for="foodCalc-age">Enter the age of your dog in months</label>
            <input type="number" class="form-input" name="foodCalc-age" min="0" id="foodCalc-age">
        </div>
        <div class="foodCalc-input">
            <div>Recommended amount to feed per day:</div>
            <div class="foodCalc-result" id="foodCalc-result"></div>
        </div>
        <p id="foodCalc-perDayPrice"></p>
    </form>
</section>