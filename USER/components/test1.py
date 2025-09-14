import os
import requests
import random

# ✅ Folder to save images
save_path = os.path.expanduser("~/Downloads/emergency_images")
os.makedirs(save_path, exist_ok=True)

# ✅ Districts and services
districts = [
    "Thiruvananthapuram", "Kollam", "Pathanamthitta", "Alappuzha", "Kottayam",
    "Idukki", "Ernakulam", "Thrissur", "Palakkad", "Malappuram",
    "Kozhikode", "Wayanad", "Kannur", "Kasaragod"
]

services = ["Hospital", "Fire & Rescue", "Police", "Ambulance", "Ham Radio"]

# ✅ Download loop using Lorem Picsum
for district in districts:
    for service in services:
        # Generate a random seed for unique image
        seed = random.randint(1, 1000)
        url = f"https://picsum.photos/seed/{seed}/400/300"

        filename = f"{district.lower().replace(' ','_')}_{service.lower().replace(' ','_')}.jpg"
        file_path = os.path.join(save_path, filename)

        try:
            response = requests.get(url, timeout=15)
            if response.status_code == 200:
                with open(file_path, "wb") as f:
                    f.write(response.content)
                print(f"✅ Saved {filename}")
            else:
                print(f"⚠️ Failed to download {filename} (Status: {response.status_code})")
        except Exception as e:
            print(f"❌ Error downloading {filename}: {e}")
