package assignment2;

public class Student {

	public String name;
	public String homedistrict;
	public int age;
	public double cgpa;
	public Student(String name,String homedistrict,int age,double cgpa){
		this.name=name;
		this.homedistrict=homedistrict;
		this.age=age;
		this.cgpa=cgpa;
		
	}
	public String convertstring(int option)
	{
		if(option==1) return name;
		else if(option==2) return homedistrict;
		else if(option==3) return Integer.toString(age);
		else if(option==4) return Double.toString(cgpa);
		return null;
	
		
	}
	
	@Override
	public String toString() {
		return  "Name: "+name+" "+"District: " +homedistrict+" "+"Age: " +age+" "+"CGPA: " +cgpa;
	}
	
}
