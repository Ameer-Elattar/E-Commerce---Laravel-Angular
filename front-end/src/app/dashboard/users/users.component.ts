import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { User } from '../../models/user';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-users',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './users.component.html',
  styleUrl: './users.component.css'
})
export class UsersComponent implements OnInit{
  users: User[] = [];

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
    this.userService.getAllUsers().subscribe((data: User[]) => {
      this.users = data;
    });
  }

  deleteUser(id: number | undefined) {
    if (id !== undefined) {
      if (confirm('Are you sure you want to delete this user?')) {
        this.userService.deleteUser(id).subscribe(() => {
          this.loadUsers();
        });
      }
    } else {
      console.error('User ID is undefined.');
    }
  }
}




