import { Component, OnInit } from '@angular/core';
import { Admin } from '../../models/admin';
import { AdminsService } from '../../services/admins.service';
import { CommonModule } from '@angular/common';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-admins',
  templateUrl: './admins.component.html',
  standalone: true,
  imports: [CommonModule,RouterLink],
  styleUrls: ['./admins.component.css'],
})

export class AdminsComponent implements OnInit {
  admins: Admin[] = [];

  constructor(private adminService: AdminsService) {}

  ngOnInit(): void {
    this.loadAdmins();
  }

  loadAdmins() {
    this.adminService.getAdmins().subscribe((data: Admin[]) => {
      this.admins = data;
    });
  }

  deleteAdmin(id: number | undefined) {
    if (id !== undefined) {
      if (confirm('Are you sure you want to delete this admin?')) {
        this.adminService.deleteAdmin(id).subscribe(() => {
          this.loadAdmins();
        });
      }
    } else {
      console.error('Admin ID is undefined.');
    }
  }
}
