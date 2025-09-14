import os
import requests
import random

# ✅ Folder where images will be saved
save_path = os.path.expanduser("~/Downloads/guides")
os.makedirs(save_path, exist_ok=True)

# ✅ Total guides
total_guides = 56

# ✅ Male and Female guides list (only for clarity/logging)
male_guides = [
    "Arun Nair", "Suresh Menon", "Ravi Kumar", "Ajay Krishnan", "Manu Varghese",
    "Hari Das", "Rahul Suresh", "Arjun Varma", "Joseph Mathew", "Nikhil Thomas",
    "Biju Jose", "Vishnu Das", "Sanjay Menon", "Naveen Pillai", "Ramesh Kumar",
    "Anil George", "Mohan Das", "Sunil Varghese", "Ashok Kumar", "Gopi Krishnan",
    "Vivek Nair", "Pranav Suresh", "Soman Pillai", "Kiran Das", "Vimal George",
    "Aravind Menon", "Nandakumar Das", "Sajin Varma"
]

female_guides = [
    "Meera Pillai", "Lakshmi Varma", "Divya Suresh", "Reshma Nair", "Anju Menon",
    "Sneha Krishnan", "Nisha Nair", "Priya Menon", "Bindu Varghese", "Anitha George",
    "Deepa Mani", "Leena Raj", "Asha Varma", "Geetha Krishnan", "Sita Mohan",
    "Kavya Raj", "Rekha Nair", "Anu Mathew", "Parvathy Menon", "Soumya Raj",
    "Athira Varma", "Radhika Menon", "Neethu Varghese", "Aparna Krishnan", "Swathi Nair",
    "Jyothi Pillai", "Devika Menon", "Keerthi Nair"
]

# ✅ Download loop
for i in range(1, total_guides + 1):
    if i % 2 == 1:  # Odd → Male
        gender = "men"
        name = male_guides[(i - 1) // 2]
    else:           # Even → Female
        gender = "women"
        name = female_guides[(i - 1) // 2]

    # Random index between 0 and 99 for unique pics
    index = random.randint(0, 99)
    url = f"https://randomuser.me/api/portraits/{gender}/{index}.jpg"

    try:
        response = requests.get(url, timeout=10)
        if response.status_code == 200:
            filename = os.path.join(save_path, f"guide{i}.jpg")
            with open(filename, "wb") as f:
                f.write(response.content)
            print(f"✅ Saved {filename} → {name} ({gender}, {index})")
        else:
            print(f"⚠️ Failed {url} (Status: {response.status_code})")
    except Exception as e:
        print(f"❌ Error downloading {url}: {e}")
