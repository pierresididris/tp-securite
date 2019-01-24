import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { FormRegisterComponent } from './form-register/form-register.component';
import { AppRoutingModule } from './app-routing.module';
import { HttpClientModule } from '@angular/common/http';
import { FormConnectionComponent } from './form-connection/form-connection.component';
import { HomeUserComponent } from './home-user/home-user.component';


@NgModule({
  declarations: [
    AppComponent,
    FormRegisterComponent,
    FormConnectionComponent,
    HomeUserComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
  ],
  providers: [],
  bootstrap: [
    AppComponent,
  ]
})
export class AppModule { }
