describe('confirmUpdateApplication', () => {
  beforeEach(() => {
    // Set up the DOM elements needed for the tests
    document.body.innerHTML = `
      <input id="application-id-hidden" type="hidden" value="123">
      <input id="meter-number-input" type="text" value="ABC123">
      <input id="first-name-input" type="text" value="john">
      <input id="middle-name-input" type="text" value="jacob">
      <input id="last-name-input" type="text" value="smith">
      <select id="name-suffix-input">
        <option value="none">None</option>
        <option value="jr">Jr.</option>
        <option value="sr">Sr.</option>
      </select>
      <input id="birth-date-input" type="text" value="01/01/2000">
      <input id="age-input" type="text" value="21 years">
      <select id="gender-input">
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
      <input id="phone-number-input" type="text" value="1234567890">
      <input id="email-input" type="text" value="john@example.com">
      <select id="property-type-input">
        <option value="residential">Residential</option>
        <option value="commercial">Commercial</option>
      </select>
      <input id="street-address-input" type="text" value="123 Main St">
      <select id="brgy-input">
        <option value="brgy1">Brgy 1</option>
        <option value="brgy2">Brgy 2</option>
      </select>
      <input id="municipality-input" type="text" value="Some Municipality">
      <input id="province-input" type="text" value="Some Province">
      <input id="region-input" type="text" value="Some Region">
      <input id="valid-id-check" type="checkbox" checked>
      <input id="proof-of-ownership-check" type="checkbox" checked>
      <input id="deed-of-sale-check" type="checkbox" checked>
      <input id="affidavit-check" type="checkbox" checked>
    `;
  });

  it('should format the name fields correctly', () => {
    confirmUpdateApplication();

    expect(formInput.firstName).toBe('John');
    expect(formInput.middleName).toBe('Jacob');
    expect(formInput.lastName).toBe('Smith');
  });

  it('should get the selected item value for the name suffix', () => {
    confirmUpdateApplication();

    expect(formInput.nameSuffix).toBe('None');

    // Simulate changing the selected option
    $('#name-suffix-input').val('sr').change();

    expect(formInput.nameSuffix).toBe('Sr.');
  });

  it('should get the age integer value', () => {
    confirmUpdateApplication();

    expect(formInput.age).toBe(21);

    // Test with an invalid age input
    $('#age-input').val('invalid').change();

    expect(formInput.age).toBeNull();
  });

  it('should get the selected item value for the gender', () => {
    confirmUpdateApplication();

    expect(formInput.gender).toBe('Male');

    // Simulate changing the selected option
    $('#gender-input').val('other').change();

    expect(formInput.gender).toBe('Other');
  });

  it('should get the checked item value for the checkboxes', () => {
    confirmUpdateApplication();

    expect(formInput.validID).toBe('Yes');
    expect(formInput.proofOfOwnership).toBe('Yes');
    expect(formInput.deedOfSale).toBe('Yes');
    expect(formInput.affidavit).toBe('Yes');

    // Uncheck a checkbox
    $('#valid-id-check').prop('checked', false).change();

    expect(formInput.validID).toBe('No');
  });

  it('should format the full name with initial correctly', () => {
    confirmUpdateApplication();

    expect(formInput.getFullNameWithInitial()).toBe('John J. Smith');

    // Test with a name suffix
    $('#name-suffix-input').val('jr').change();

    expect(formInput.getFullNameWithInitial()).toBe('John J. Smith Jr.');
  });

  it('should format the full address correctly', () => {
    confirmUpdateApplication();

    expect(formInput.getFullAddress()).toBe('123 Main St, Brgy 1, Some Municipality, Some Province, Some Region, Philippines');
  });
});