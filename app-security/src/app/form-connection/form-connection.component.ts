import { Component, OnInit } from '@angular/core';
import { User } from '../user';
import { UserService } from '../user.service';
import { RouterModule, Routes, Router } from '@angular/router';

@Component({
  selector: 'app-form-connection',
  templateUrl: './form-connection.component.html',
  styleUrls: ['./form-connection.component.css']
})
export class FormConnectionComponent implements OnInit {
  user: User;
  invalidMail: boolean;
  noUser: boolean;
  recuperationMail: string;
  mailSent: boolean;

  constructor(
    private userService: UserService,
    private router: Router
  ) { }

  ngOnInit() {
    this.user = new User();
    this.invalidMail = false;
    this.noUser = false;
    this.mailSent = false;
  }

  connect(): void {
    this.invalidMail = false;
    this.noUser = false;
    this.mailSent = false;
    if(this.userService.checkMail(this.user.email)){
      this.userService.connectUser(this.user).subscribe((response) => {
        if(response !== "error"){
          this.userService.connectedUser = this.user;
          this.userService.connectedUser.id = response;
          this.router.navigate(['/home-user']);
        }else{
          this.noUser = true;
        }
      });
    }else{
      this.invalidMail = true;
    }
  }

  forgetPwd(): void {
    this.userService.forgetPwd('test').subscribe((response) => {
      this.mailSent = true;
    });
  }

}
