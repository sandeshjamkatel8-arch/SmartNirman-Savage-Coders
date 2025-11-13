// public/assets/js/data.js
window.DEMO_PROJECTS = [
  {
    id: 1,
    title: "Ward 5 Road Upgrading",
    location: "Hetauda-5",
    budget_total: 2500000,
    budget_spent: 950000,
    status: "ongoing",
    contractor_name: "Shivashakti Builders",
    updated_at: "2025-11-10"
  },
  {
    id: 2,
    title: "Primary School Classroom Repair",
    location: "Hetauda-11",
    budget_total: 1200000,
    budget_spent: 1200000,
    status: "completed",
    contractor_name: "Sunaulo Nirman",
    updated_at: "2025-10-05"
  },
  {
    id: 3,
    title: "Community Drinking Water Line",
    location: "Hetauda-2",
    budget_total: 1800000,
    budget_spent: 400000,
    status: "ongoing",
    contractor_name: "Shree Ganapati Construction",
    updated_at: "2025-11-08"
  }
];

// --- approved updates (shown on project detail)
window.DEMO_UPDATES = [
  {
    id: 101, project_id: 1, title: "Sub-base laid (50m)",
    desc: "Compaction complete; base course next.",
    percent_complete: 28, amount_spent: 450000,
    photo_url: "./assets/img/road_1.jpg", bill_filename: "bill_101.pdf",
    is_approved: true, created_at: "2025-11-05"
  },
  {
    id: 102, project_id: 1, title: "Drain line excavation",
    desc: "Excavation along east side.",
    percent_complete: 36, amount_spent: 500000,
    photo_url: "./assets/img/road_2.jpg", bill_filename: "bill_102.pdf",
    is_approved: true, created_at: "2025-11-10"
  },
  {
    id: 201, project_id: 2, title: "Final handover",
    desc: "Painting and desks delivered.",
    percent_complete: 100, amount_spent: 300000,
    photo_url: "./assets/img/school_1.jpg", bill_filename: "bill_201.pdf",
    is_approved: true, created_at: "2025-09-30"
  }
];

// --- grievances (public complaints)
window.DEMO_COMPLAINTS = [
  {
    id: 5001,
    name: "Ramesh",
    contact: "98XXXXXXXX",
    ward: "Hetauda-5",
    project_id: 1,
    subject: "Gravel not compacted",
    details: "Heavy vehicles are struggling; need compaction.",
    photo_url: "./assets/img/road_2.jpg",
    status: "open",
    created_at: "2025-11-11"
  },
  {
    id: 5002,
    name: "Sita",
    contact: "",
    ward: "Hetauda-11",
    project_id: 2,
    subject: "Classroom leakage fixed quickly",
    details: "Thanks to the team; roof looks fine now.",
    photo_url: "",
    status: "resolved",
    created_at: "2025-10-12"
  }
];
