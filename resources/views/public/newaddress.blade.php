@extends('layouts.app')
@section('content')

<div class="site__body">
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
      <div class="container container--max--xl">
        <div class="row">
          <div class="col-12 col-lg-3 d-flex">
            <div class="account-nav flex-grow-1">
              <h4 class="account-nav__title">Navigation</h4>
              <ul class="account-nav__list">
               
                <li class="account-nav__item">
                  <a href={{route('editprofile')}}>Edit Profile</a>
                </li>
                <li class="account-nav__item">
                  <a href={{route('orderhistory')}}>Order History</a>
                </li>
               
                <li class="account-nav__item">
                  <a href={{route('address')}}>Addresses</a>
                </li>
               
                
                <li class="account-nav__divider" role="presentation"></li>
                <li class="account-nav__item">
                  <a href="account-login.html">Logout</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-lg-9 mt-4 mt-lg-0">
            <div class="card">
              <div class="card-header"><h5>New Address</h5></div>
              <div class="card-divider"></div>
              <div class="card-body card-body--padding--2">
                <div class="row no-gutters">
                  <div class="col-12 col-lg-10 col-xl-8">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="address-first-name">Name</label>
                        <input
                          type="text"
                          class="form-control"
                          id="address-first-name"
                          placeholder="Your Name"
                        />
                      </div>
                      <div class="form-group col-md-6">
                        <label for="address-last-name">Mobile Number</label>
                        <input
                          type="text"
                          class="form-control"
                          id="address-last-name"
                          placeholder="Your Mobile"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="address-address1">Street Address</label>
                        <input
                          type="text"
                          class="form-control"
                          id="address-address1"
                          placeholder="House number and street name"
                        />
                        <label for="address-address2" class="sr-only"
                          >Street Address</label
                        >
                        <input
                          type="text"
                          class="form-control mt-2"
                          id="address-address2"
                          placeholder="Apartment, suite, unit etc."
                        />
                      </div>
                  
                    <div class="form-group">
                      <label for="address-country">Country</label>
                      <select id="address-country" class="form-control">
                        <option value="">Select a country...</option>
                        <option value="AU">India</option>
                        <option value="DE">Germany</option>
                        <option value="FR">France</option>
                        <option value="IT">Italy</option>
                        <option value="RU">Russia</option>
                        <option value="UA">Ukraine</option>
                        <option value="US">United States</option>
                      </select>
                    </div>
                   
                    <div class="form-group">
                      <label for="address-city">City</label>
                      <input
                        type="text"
                        class="form-control"
                        id="address-city"
                        placeholder="Enter City"
                      />
                    </div>
                    <div class="form-group">
                      <label for="address-state">State</label>
                      <input
                        type="text"
                        class="form-control"
                        id="address-state"
                        placeholder="Enter State"
                      />
                    </div>
                    <div class="form-group">
                      <label for="address-postcode">Pincode</label>
                      <input
                        type="text"
                        class="form-control"
                        id="address-postcode"
                        placeholder="Enter Pincode"
                      />
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                          <label for="address-email">Landmark(optional)</label>
                          <input
                            type="email"
                            class="form-control"
                            id="address-email"
                            placeholder="Enter Landmark"
                          />
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="address-email">Alternate Phone(optional)</label>
                            <input
                              type="email"
                              class="form-control"
                              id="address-email"
                              placeholder="Alternate Phone"
                            />
                          </div>
                       
                      </div>
                    <div class="form-row">
                      <div class="form-group col-md-6 mb-0">
                        <label for="address-email">Email address</label>
                        <input
                          type="email"
                          class="form-control"
                          id="address-email"
                          placeholder="user@example.com"
                        />
                      </div>
                     
                    </div>
                    <div class="form-group mt-3">
                      <div class="form-check">
                        <span class="input-check form-check-input"
                          ><span class="input-check__body"
                            ><input
                              class="input-check__input"
                              type="checkbox"
                              id="default-address" />
                            <span class="input-check__box"></span>
                            <span class="input-check__icon"
                              ><svg width="9px" height="7px">
                                <path
                                  d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z"
                                />
                              </svg> </span></span></span
                        ><label
                          class="form-check-label"
                          for="default-address"
                          >Set as my default address</label
                        >
                      </div>
                    </div>
                    <div class="form-group mb-0 pt-3 mt-3">
                      <button class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="block-space block-space--layout--before-footer"></div>
  </div>



@endsection