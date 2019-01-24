import { Component, OnInit } from '@angular/core';
import { UserService } from '../user.service';
import { User } from '../user';

@Component({
  selector: 'app-home-user',
  templateUrl: './home-user.component.html',
  styleUrls: ['./home-user.component.css']
})
export class HomeUserComponent implements OnInit {
  userList: User[];

  constructor(
    private userService: UserService,
  ) { }

  ngOnInit() {
    this.userService.getUserList().then((response) => {
      if(response instanceof Array){
        this.userList = response;
      }
    });
  }

}
