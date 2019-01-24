import { Component } from '@angular/core';
import { UserService } from './user.service';
import { Router } from '@angular/router';
import { User } from './user';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app-security';

  constructor(
    public userService: UserService,
    private router: Router,
  ){

  }

  ngOnInit(){

  }

  disconnectUser(): void {
    console.log("disconnectUser");
    this.userService.deconnectUser().subscribe((response) => {
      this.userService.connectedUser = new User();
      this.router.navigate(['/connection']);
    });
  }
}
