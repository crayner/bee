<?php

namespace Busybee\AVETMISS\AVETMISSBundle\Update\dBase;

use Busybee\Core\SystemBundle\Model\PluginManager;

/**
 * Update 0.0.00
 *
 * @version    15th November 2016
 * @since      15th November 2016
 * @author     Craig Rayner
 */
class Update_0_0_00 extends PluginManager
{
	/**
	 * @var    integer
	 */
	protected $count = 17;

	/**
	 * build
	 *
	 * @version    15th November 2016
	 * @since      20th October 2016
	 *
	 * @param    string $version
	 *
	 * @return    boolean
	 */
	public function build()
	{

		$role = $this->em->getRepository('BusybeeSecurityBundle:Role');
		//1
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('string');
		$entity->setValue('0.0.01');
		$entity->setName('AVETMISS.Version');
		$entity->setDisplayName('AVETMISS Plugin Version');
		$entity->setDescription('The version details for the AVETMISS Plugin.');
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//2
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('boolean');
		$entity->setValue(true);
		$entity->setName('AVETMISS.Installed');
		$entity->setDisplayName('AVETMISS Plugin Installed');
		$entity->setDescription('The AVETMISS Plugin has been installed.');
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//3
		$territories = array(
			'Not Specified'                 => '@@',
			'New South Wales'               => 'NSW',
			'Victoria'                      => 'VIC',
			'Queensland'                    => 'QLD',
			'South Australia'               => 'SA',
			'Western Australia'             => 'WA',
			'Tasmania'                      => 'TAS',
			'Northern Territory'            => 'NT',
			'Australian Capital Territory'  => 'ACT',
			'Overseas Australian Territory' => 'OAT',
			'Overseas'                      => 'OS'
		);

		$this->container->get('busybee_core_system.setting.setting_manager')->set('Address.TerritoryList', $territories);
		//4
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('string');
		$entity->setValue('00');
		$entity->setName('AVETMISS.Org.Type');
		$entity->setDisplayName('AVETMISS Training organisation type identifier');
		$entity->setDescription('Data defined in AVETMISS atandards.');
		$entity->setChoice('parameter.AVETMISS.Org_Type_List');
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//5
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue('');
		$entity->setName('AVETMISS.Location.List');
		$entity->setDisplayName('AVETMISS Training Organisation Delivery Locations');
		$entity->setDescription('A list of locations that your training organisation uses to deliver training.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_REGISTRAR'));

		$this->sm->createSetting($entity);
		//6
		$this->container->get('busybee_core_system.setting.setting_manager')->set('CountryType', 'Busybee\AVETMISS\AVETMISSBundle\Type\CountryType');
		//7
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
choices:
    Nationally accredited qualification: 11
    Nationally recognised accredited course: 12
    Nationally recognised skill set: 13
    Other course: 14
    Higher level qualification: 15
    Locally recognised skill set: 16
description: 
    11: Nationally accredited qualification specified in a national training package must only be used for a nationally accredited program of study which is designed to lead to a qualification specified in an endorsed national training package.
    12: Nationally recognised accredited course, other than a qualification specified in a national training package must only be used for a nationally recognised accredited course endorsed by state or territory recognition authorities or registered training organisations with delegated authority to self-manage accreditation.
    13: Nationally recognised skill set, specified in a national training package must only be used for a skill set endorsed in a training package.
    14: Other course must be used for a local course developed by training organisations or where developed by industry, enterprise, community education or professional bodies to meet an identified training need.
    15: Higher level qualification is accredited by state or territory government accreditation authorities or higher education institutions with self-accrediting authority in line with the Protocols for Higher Education Approval Processes. The level of education for these qualifications must be in the range from ‘211 — Graduate diploma’ to ‘421 — Diploma’.
    16: Locally recognised skill set must be used for skill sets other than those specified in training packages.
");
		$entity->setName('AVETMISS.Recognition.Identifier');
		$entity->setDisplayName('Programme Recognition Identifier');
		$entity->setDescription('Program recognition identifier distinguishes a qualification, course or skill set by its level of recognition in the VET sector.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//8
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
Graduate diploma level:
    Graduate diploma: 211
Graduate certificate level:
    Graduate certificate: 221
Bachelor degree level:
    Bachelor degree (Honours): 311
    Bachelor degree (Pass): 312
Advanced diploma and associate degree level:
    Advanced diploma: 411
    Associate degree: 412
Diploma level:
    Diploma: 421
Certificate III & IV level: 
    Certificate IV: 511
    Certificate III: 514
Certificate I & II level:
    Certificate II: 521
    Certificate I: 524
Senior secondary education:
    Year 12: 611
    Year 11: 613
Junior secondary education:
    Year 10: 621
Other education – non-award courses:
    Other non-award courses: 912
Other education – miscellaneous education:
    Statement of attainment not identifiable by level: 991
    Bridging and enabling courses not identifiable by level: 992
    Education not elsewhere classified: 999
");
		$entity->setName('AVETMISS.Level.Education');
		$entity->setDisplayName('Programme Level of Education Identifier');
		$entity->setDescription('Programme level of education identifier identifies the degree of complexity of the program of study. This classification is based on the Australian Standard Classification of Education (ASCED), ABS catalogue no.1272.0, 2001.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//9
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
NATURAL AND PHYSICAL SCIENCES:
    Mathematical Sciences: '0101'
    Physics and Astronomy: '0103'
    Chemical Sciences: '0105'
    Earth Sciences: '0107'
    Biological Sciences: '0109'
    Other Natural and Physical Sciences: '0199'
INFORMATION TECHNOLOGY:
    Computer Science: '0201'
    Information Systems: '0203'
    Other Information Technology: '0299'
ENGINEERING AND RELATED TECHNOLOGIES:
    Manufacturing Engineering and Technology: '0301'
    Process and Resources Engineering: '0303'
    Automotive Engineering and Technology: '0305'
    Mechanical and Industrial Engineering and Technology: '0307'
    Civil Engineering: '0309'
    Geomatic Engineering: '0311'
    Electrical and Electronic Engineering and Technology: '0313'
    Aerospace Engineering and Technology: '0315'
    Maritime Engineering and Technology: '0317'
    Other Engineering and Related Technologies: '0399'
ARCHITECTURE AND BUILDING:
    Architecture and Urban Environment: '0401'
    Building: '0403'
AGRICULTURE, ENVIRONMENTAL AND RELATED STUDIES:
    Agriculture: '0501'
    Horticulture and Viticulture: '0503'
    Forestry Studies: '0505'
    Fisheries Studies: '0507'
    Environmental Studies: '0509'
    Other Agriculture, Environmental and Related Studies: '0599'
HEALTH:
    Medical Studies: '0601'
    Nursing: '0603'
    Pharmacy: '0605'
    Dental Studies: '0607'
    Optical Science: '0609'
    Veterinary Studies: '0611'
    Public Health: '0613'
    Radiography: '0615'
    Rehabilitation Therapies: '0617'
    Complementary Therapies: '0619'
    Other Health: '0699'
EDUCATION:
    Teacher Education: '0701'
    Curriculum and Education Studies: '0703'
    Other Education: '0799'
MANAGEMENT AND COMMERCE:
    Accounting: '0801'
    Business and Management: '0803'
    Sales and Marketing: '0805'
    Tourism: '0807'
    Office Studies: '0809'
    Banking, Finance and Related Fields: '0811'
    Other Management and Commerce: '0899'
SOCIETY AND CULTURE:
    Political Science and Policy Studies: '0901'
    Studies in Human Society: '0903'
    Human Welfare Studies and Services: '0905'
    Behavioural Science: '0907'
    Law: '0909'
    Justice and Law Enforcement: '0911'
    Librarianship, Information Management and Curatorial Studies: '0913'
    Language and Literature: '0915'
    Philosophy and Religious Studies: '0917'
    Economics and Econometrics: '0919'
    Sport and Recreation: '0921'
    Other Society and Culture: '0999'
CREATIVE ARTS:
    Performing Arts: '1001'
    Visual Arts and Crafts: '1003'
    Graphic and Design Studies: '1005'
    Communication and Media Studies: '1007'
    Other Creative Arts: '1099'
FOOD, HOSPITALITY AND PERSONAL SERVICES:
    Food and Hospitality: '1101'
    Personal Services: '1103'
MIXED FIELD PROGRAMMES:
    General Education Programmes: '1201'
    Social Skills Programmes: '1203'
    Employment Skills Programmes: '1205'
    Other Mixed Field Programmes: '1299'
");
		$entity->setName('AVETMISS.Program.FOE');
		$entity->setDisplayName('Programme Field of Education Identifier');
		$entity->setDescription('Program field of education identifier is a code that identifies the subject matter that is the ultimate aim of the skills and knowledge gained in a qualification, course or skill set.  The Program field of education identifier is based on the field of education (FOE) at the narrow level (4-digit), which is one part of the Australian Standard Classification of Education (ASCED), ABS catalogue no.1272.0, 2001.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//10
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
NATURAL AND PHYSICAL SCIENCES:
    Mathematical Sciences:
        Mathematics: '010101'
        Statistics: '010103'
        Mathematical Sciences, n.e.c.: '010199'
    Physics and Astronomy:
        Physics: '010301'
        Astronomy: '010303'
    Chemical Sciences:
        Organic Chemistry: '010501'
        Inorganic Chemistry: '010503'
        Chemical Sciences, n.e.c.: '010599'
    Earth Sciences:
        Atmospheric Sciences: '010701'
        Geology: '010703'
        Geophysics: '010705'
        Geochemistry: '010707'
        Soil Science: '010709'
        Hydrology: '010711'
        Oceanography: '010713'
        Earth Sciences, n.e.c.: '010799'
    Biological Sciences:
        Biochemistry and Cell Biology: '010901'
        Botany: '010903'
        Ecology and Evolution: '010905'
        Marine Science: '010907'
        Genetics: '010909'
        Microbiology: '010911'
        Human Biology: '010913'
        Zoology: '010915'
        Biological Sciences, n.e.c.: '010999'
    Other Natural and Physical Sciences:
        Medical Science: '019901'
        Forensic Science: '019903'
        Food Science and Biotechnology: '019905'
        Pharmacology: '019907'
        Laboratory Technology: '019909'
        Natural and Physical Sciences, n.e.c.: '019999'
INFORMATION TECHNOLOGY:
    Computer Science:
        Formal Language Theory: '020101'
        Programming: '020103'
        Computational Theory: '020105'
        Compiler Construction: '020107'
        Algorithms: '020109'
        Data Structures: '020111'
        Networks and Communications: '020113'
        Computer Graphics: '020115'
        Operating Systems: '020117'
        Artificial Intelligence: '020119'
        Computer Science, n.e.c.: '020199'
    Information Systems:
        Conceptual Modelling: '020301'
        Database Management: '020303'
        Systems Analysis and Design: '020305'
        Decision Support Systems: '020307'
        Information Systems, n.e.c.: '020399'
    Other Information Technology:
        Security Science: '029901'
        Information Technology, n.e.c.: '029999'
ENGINEERING AND RELATED TECHNOLOGIES:
    Manufacturing Engineering and Technology:
        Manufacturing Engineering: '030101'
        Printing: '030103'
        Textile Making: '030105'
        Garment Making: '030107'
        Footwear Making: '030109'
        Wood Machining and Turning: '030111'
        Cabinet Making: '030113'
        Furniture Upholstery and Renovation: '030115'
        Furniture Polishing: '030117'
        Manufacturing Engineering and Technology, n.e.c.: '030199'
    Process and Resources Engineering:
        Chemical Engineering: '030301'
        Mining Engineering: '030303'
        Materials Engineering: '030305'
        Food Processing Technology: '030307'
        Process and Resources Engineering, n.e.c.: '030399'
    Automotive Engineering and Technology:
        Automotive Engineering: '030501'
        Vehicle Mechanics: '030503'
        Automotive Electrics and Electronics: '030505'
        Automotive Vehicle Refinishing: '030507'
        Automotive Body Construction: '030509'
        Panel Beating: '030511'
        Upholstery and Vehicle Trimming: '030513'
        Automotive Vehicle Operations: '030515'
        Automotive Engineering and Technology, n.e.c.: '030599'
    Mechanical and Industrial Engineering and Technology:
        Mechanical Engineering: '030701'
        Industrial Engineering: '030703'
        Toolmaking: '030705'
        Metal Fitting, Turning and Machining: '030707'
        Sheetmetal Working: '030709'
        Boilermaking and Welding: '030711'
        Metal Casting and Patternmaking: '030713'
        Precision Metalworking: '030715'
        Plant and Machine Operations: '030717'
        Mechanical and Industrial Engineering and Technology, n.e.c.: '030799'
    Civil Engineering:
        Construction Engineering: '030901'
        Structural Engineering: '030903'
        Building Services Engineering: '030905'
        Water and Sanitary Engineering: '030907'
        Transport Engineering: '030909'
        Geotechnical Engineering: '030911'
        Ocean Engineering: '030913'
        Civil Engineering, n.e.c.: '030999'
    Geomatic Engineering:
        Surveying: '031101'
        Mapping Science: '031103'
        Geomatic Engineering, n.e.c.: '031199'
    Electrical and Electronic Engineering and Technology:
        Electrical Engineering: '031301'
        Electronic Engineering: '031303'
        Computer Engineering: '031305'
        Communications Technologies: '031307'
        Communications Equipment Installation and Maintenance: '031309'
        Powerline Installation and Maintenance: '031311'
        Electrical Fitting, Electrical Mechanics: '031313'
        Refrigeration and Air Conditioning Mechanics: '031315'
        Electronic Equipment Servicing: '031317'
        Electrical and Electronic Engineering and Technology, n.e.c.: '031399'
    Aerospace Engineering and Technology:
        Aerospace Engineering: '031501'
        Aircraft Maintenance Engineering: '031503'
        Aircraft Operation: '031505'
        Air Traffic Control: '031507'
        Aerospace Engineering and Technology, n.e.c.: '031599'
    Maritime Engineering and Technology:
        Maritime Engineering: '031701'
        Marine Construction: '031703'
        Marine Craft Operation: '031705'
        Maritime Engineering and Technology, n.e.c.: '031799'
    Other Engineering and Related Technologies:
        Environmental Engineering: '039901'
        Biomedical Engineering: '039903'
        Fire Technology: '039905'
        Rail Operations: '039907'
        Cleaning: '039909'
        Engineering and Related Technologies, n.e.c.: '039999'
ARCHITECTURE AND BUILDING:
    Architecture and Urban Environment:
        Architecture: '040101'
        Urban Design and Regional Planning: '040103'
        Landscape Architecture: '040105'
        Interior and Environmental Design: '040107'
        Architecture and Urban Environment, n.e.c.: '040199'
    Building:
        Building Science and Technology: '040301'
        Building Construction Management: '040303'
        Building Surveying: '040305'
        Building Construction Economics: '040307'
        Bricklaying and Stonemasonry: '040309'
        Carpentry and Joinery: '040311'
        Ceiling, Wall and Floor Fixing: '040313'
        Roof Fixing: '040315'
        Plastering: '040317'
        Furnishing Installation: '040319'
        Floor Coverings: '040321'
        Glazing: '040323'
        Painting, Decorating and Sign Writing: '040325'
        Plumbing: '040327'
        Scaffolding and Rigging: '040329'
        Building, n.e.c.: '040399'
AGRICULTURE, ENVIRONMENTAL AND RELATED STUDIES:
    Agriculture:
        Agricultural Science: '050101'
        Wool Science: '050103'
        Animal Husbandry: '050105'
        Agriculture, n.e.c.: '050199'
    Horticulture and Viticulture:
        Horticulture: '050301'
        Viticulture: '050303'
    Forestry Studies:
        Forestry Studies: '050501'
    Fisheries Studies:
        Aquaculture: '050701'
        Fisheries Studies, n.e.c.: '050799'
    Environmental Studies:
        Land, Parks and Wildlife Management: '050901'
        Environmental Studies, n.e.c.: '050999'
    Other Agriculture, Environmental and Related Studies:
        Pest and Weed Control: '059901'
        Agriculture, Environmental and Related Studies, n.e.c.: '059999'
HEALTH:
    Medical Studies:
        General Medicine: '060101'
        Surgery: '060103'
        Psychiatry: '060105'
        Obstetrics and Gynaecology: '060107'
        Paediatrics: '060109'
        Anaesthesiology: '060111'
        Pathology: '060113'
        Radiology: '060115'
        Internal Medicine: '060117'
        General Practice: '060119'
        Medical Studies, n.e.c.: '060199'
    Nursing:
        General Nursing: '060301'
        Midwifery: '060303'
        Mental Health Nursing: '060305'
        Community Nursing: '060307'
        Critical Care Nursing: '060309'
        Aged Care Nursing: '060311'
        Palliative Care Nursing: '060313'
        Mothercraft Nursing and Family and Child Health Nursing: '060315'
        Nursing, n.e.c.: '060399'
    Pharmacy:
        Pharmacy: '060501'
    Dental Studies:
        Dentistry: '060701'
        Dental Assisting: '060703'
        Dental Technology: '060705'
        Dental Studies, n.e.c.: '060799'
    Optical Science:
        Optometry: '060901'
        Optical Technology: '060903'
        Optical Science, n.e.c.: '060999'
    Veterinary Studies:
        Veterinary Science: '061101'
        Veterinary Assisting: '061103'
        Veterinary Studies, n.e.c.: '061199'
    Public Health:
        Occupational Health and Safety: '061301'
        Environmental Health: '061303'
        Indigenous Health: '061305'
        Health Promotion: '061307'
        Community Health: '061309'
        Epidemiology: '061311'
        Public Health, n.e.c.: '061399'
    Radiography:
        Radiography: '061501'
    Rehabilitation Therapies:
        Physiotherapy: '061701'
        Occupational Therapy: '061703'
        Chiropractic and Osteopathy: '061705'
        Speech Pathology: '061707'
        Audiology: '061709'
        Massage Therapy: '061711'
        Podiatry: '061713'
        Rehabilitation Therapies, n.e.c.: '061799'
    Complementary Therapies:
        Naturopathy: '061901'
        Acupuncture: '061903'
        Traditional Chinese Medicine: '061905'
        Complementary Therapies, n.e.c.: '061999'
    Other Health:
        Nutrition and Dietetics: '069901'
        Human Movement: '069903'
        Paramedical Studies: '069905'
        First Aid: '069907'
        Health, n.e.c.: '069999'
EDUCATION:
    Teacher Education:
        'Teacher Education Early Childhood': '070101'
        'Teacher Education: Primary': '070103'
        'Teacher Education: Secondary': '070105'
        Teacher-Librarianship: '070107'
        'Teacher Education: Vocational Education and Training': '070109'
        'Teacher Education: Higher Education': '070111'
        'Teacher Education: Special Education': '070113'
        English as a Second Language Teaching: '070115'
        Nursing Education Teacher Training: '070117'
        Teacher Education, n.e.c.: '070199'
    Curriculum and Education Studies:
        Curriculum Studies: '070301'
        Education Studies: '070303'
    Other Education:
        Education, n.e.c.: '079999'
MANAGEMENT AND COMMERCE:
    Accounting:
        Accounting: '080101'
    Business and Management:
        Business Management: '080301'
        Human Resource Management: '080303'
        Personal Management Training: '080305'
        Organisation Management: '080307'
        Industrial Relations: '080309'
        International Business: '080311'
        Public and Health Care Administration: '080313'
        Project Management: '080315'
        Quality Management: '080317'
        Hospitality Management: '080319'
        Farm Management and Agribusiness: '080321'
        Tourism Management: '080323'
        Business and Management, n.e.c.: '080399'
    Sales and Marketing:
        Sales: '080501'
        Real Estate: '080503'
        Marketing: '080505'
        Advertising: '080507'
        Public Relations: '080509'
        Sales and Marketing, n.e.c.: '080599'
    Tourism:
        Tourism: '080701'
    Office Studies:
        Secretarial and Clerical Studies: '080901'
        Keyboard Skills: '080903'
        Practical Computing Skills: '080905'
        Office Studies, n.e.c.: '080999'
    Banking, Finance and Related Fields:
        Banking and Finance: '081101'
        Insurance and Actuarial Studies: '081103'
        Investment and Securities: '081105'
        Banking, Finance and Related Fields, n.e.c.: '081199'
    Other Management and Commerce:
        Purchasing, Warehousing and Distribution: '089901'
        Valuation: '089903'
        Management and Commerce, n.e.c.: '089999'
SOCIETY AND CULTURE:
    Political Science and Policy Studies:
        Political Science: '090101'
        Policy Studies: '090103'
    Studies in Human Society:
        Sociology: '090301'
        Anthropology: '090303'
        History: '090305'
        Archaeology: '090307'
        Human Geography: '090309'
        Indigenous Studies: '090311'
        Gender Specific Studies: '090313'
        Studies in Human Society, n.e.c.: '090399'
    Human Welfare Studies and Services:
        Social Work: '090501'
        Children's Services: '090503'
        Youth Work: '090505'
        Care for the Aged: '090507'
        Care for the Disabled: '090509'
        Residential Client Care: '090511'
        Counselling: '090513'
        Welfare Studies: '090515'
        Human Welfare Studies and Services, n.e.c.: '090599'
    Behavioural Science:
        Psychology: '090701'
        Behavioural Science, n.e.c.: '090799'
    Law:
        Business and Commercial Law: '090901'
        Constitutional Law: '090903'
        Criminal Law: '090905'
        Family Law: '090907'
        International Law: '090909'
        Taxation Law: '090911'
        Legal Practice: '090913'
        Law, n.e.c.: '090999'
    Justice and Law Enforcement:
        Justice Administration: '091101'
        Legal Studies: '091103'
        Police Studies: '091105'
        Justice and Law Enforcement, n.e.c.: '091199'
    Librarianship, Information Management and Curatorial Studies:
        Librarianship and Information Management: '091301'
        Curatorial Studies: '091303'
    Language and Literature:
        English Language: '091501'
        Northern European Languages: '091503'
        Southern European Languages: '091505'
        Eastern European Languages: '091507'
        Southwest Asian and North African Languages: '091509'
        Southern Asian Languages: '091511'
        Southeast Asian Languages: '091513'
        Eastern Asian Languages: '091515'
        Australian Indigenous Languages: '091517'
        Translating and Interpreting: '091519'
        Linguistics: '091521'
        Literature: '091523'
        Language and Literature, n.e.c.: '091599'
    Philosophy and Religious Studies:
        Philosophy: '091701'
        Religious Studies: '091703'
    Economics and Econometrics:
        Economics: '091901'
        Econometrics: '091903'
    Sport and Recreation:
        Sport and Recreation Activities: '092101'
        Sports Coaching, Officiating and Instruction: '092103'
        Sport and Recreation, n.e.c.: '092199'
    Other Society and Culture:
        Family and Consumer Studies: '099901'
        Criminology: '099903'
        Security Services: '099905'
        Society and Culture, n.e.c.: '099999'
CREATIVE ARTS:
    Performing Arts:
        Music: '100101'
        Drama and Theatre Studies: '100103'
        Dance: '100105'
        Performing Arts, n.e.c.: '100199'
    Visual Arts and Crafts:
        Fine Arts: '100301'
        Photography: '100303'
        Crafts: '100305'
        Jewellery Making: '100307'
        Floristry: '100309'
        Visual Arts and Crafts, n.e.c.: '100399'
    Graphic and Design Studies:
        Graphic Arts and Design Studies: '100501'
        Textile Design: '100503'
        Fashion Design: '100505'
        Graphic and Design Studies, n.e.c.: '100599'
    Communication and Media Studies:
        Audio Visual Studies: '100701'
        Journalism: '100703'
        Written Communication: '100705'
        Verbal Communication: '100707'
        Communication and Media Studies, n.e.c.: '100799'
    Other Creative Arts:
        Creative Arts, n.e.c.: '109999'
FOOD, HOSPITALITY AND PERSONAL SERVICES:
    Food and Hospitality:
        Hospitality: '110101'
        Food and Beverage Service: '110103'
        Butchery: '110105'
        Baking and Pastrymaking: '110107'
        Cookery: '110109'
        Food Hygiene: '110111'
        Food and Hospitality, n.e.c.: '110199'
    Personal Services:
        Beauty Therapy: '110301'
        Hairdressing: '110303'
        Personal Services, n.e.c.: '110399'
MIXED FIELD PROGRAMMES:
    General Education Programmes:
        General Primary and Secondary Education Programmes: '120101'
        Literacy and Numeracy Programmes: '120103'
        Learning Skills Programmes: '120105'
        General Education Programmes, n.e.c.: '120199'
    Social Skills Programmes:
        Social and Interpersonal Skills Programmes: '120301'
        Survival Skills Programmes: '120303'
        Parental Education Programmes: '120305'
        Social Skills Programmes, n.e.c.: '120399'
    Employment Skills Programmes:
        Career Development Programmes: '120501'
        Job Search Skills Programmes: '120503'
        Work Practices Programmes: '120505'
        Employment Skills Programmes, n.e.c.: '120599'
    Other Mixed Field Programmes:
        Mixed Field Programmes, n.e.c.: '129999'
");
		$entity->setName('AVETMISS.Subject.FOE');
		$entity->setDisplayName('Subject Field of Education Identifier');
		$entity->setDescription('Subject field of education identifier is a code that identifies the subject matter that is the ultimate aim of the skills and knowledge gained in a qualification, course or skill set. ');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//11
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
Did not go to school: '02'
Year 8 or below: '08'
Year 9 or equivalent: '09'
Completed Year 10: '10'
Completed Year 11: '11'
Completed Year 12: '12'
");
		$entity->setName('AVETMISS.Client.schoolAttainment');
		$entity->setDisplayName('Highest school level completed identifier');
		$entity->setDescription('Highest school level completed identifier identifies the highest level of school that a client has completed.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//12
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
'Yes, Aboriginal': '1'
'Yes, Torres Strait Islander': '2'
'Yes, Aboriginal AND Torres Strait Islander': '3'
'No, Neither Aboriginal nor Torres Strait Islander': '4'
");
		$entity->setName('AVETMISS.Client.indigenous');
		$entity->setDisplayName('Indigenous Status Identifier');
		$entity->setDescription('Indigenous status identifier indicates a client who self-identifies as being of Australian Aboriginal or Torres Strait Islander descent');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//13
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
NORTHERN EUROPEAN LANGUAGES:
    Celtic:
        Gaelic (Scotland): '1101'
        Irish: '1102'
        Welsh: '1103'
        Celtic, nec: '1199'
    English:
        English: '1201'
    German and Related Languages:
        German: '1301'
        Letzeburgish: '1302'
        Yiddish: '1303'
    Dutch and Related Languages:
        Dutch: '1401'
        Frisian: '1402'
        Afrikaans: '1403'
    Scandinavian:
        Danish: '1501'
        Icelandic: '1502'
        Norwegian: '1503'
        Swedish: '1504'
        Scandinavian, nec: '1599'
    Finnish and Related Languages:
        Estonian: '1601'
        Finnish: '1602'
        Finnish and Related Languages, nec: '1699'

SOUTHERN EUROPEAN LANGUAGES:
    French:
        French: '2101'
    Greek:
        Greek: '2201'
    Iberian Romance:
        Catalan: '2301'
        Portuguese: '2302'
        Spanish: '2303'
        Iberian Romance, nec: '2399'
    Italian:
        Italian: '2401'
    Maltese:
        Maltese: '2501'
    Other Southern European Languages:
        Basque: '2901'
        Latin: '2902'
        Other Southern European Languages, nec: '2999'

EASTERN EUROPEAN LANGUAGES:
    Baltic:
        Latvian: '3101'
        Lithuanian: '3102'
    Hungarian:
        Hungarian: '3301'
    East Slavic:
        Belorussian: '3401'
        Russian: '3402'
        Ukrainian: '3403'
    South Slavic:
        Bosnian: '3501'
        Bulgarian: '3502'
        Croatian: '3503'
        Macedonian: '3504'
        Serbian: '3505'
        Slovene: '3506'
        Serbo-Croatian/Yugoslavian, so described: '3507'
    West Slavic:
        Czech: '3601'
        Polish: '3602'
        Slovak: '3603'
        Czechoslovakian, so described: '3604'
    Other Eastern European Languages:
        Albanian: '3901'
        Aromunian (Macedo-Romanian): '3903'
        Romanian: '3904'
        Romany: '3905'
        Other Eastern European Languages, nec: '3999'

SOUTHWEST AND CENTRAL ASIAN LANGUAGES:
    Iranic:
        Kurdish: '4101'
        Pashto: '4102'
        Balochi: '4104'
        Dari: '4105'
        Persian (excluding Dari): '4106'
        Hazaraghi: '4107'
        Iranic, nec: '4199'
    Middle Eastern Semitic Languages:
        Arabic: '4202'
        Hebrew: '4204'
        Assyrian Neo-Aramaic: '4206'
        Chaldean Neo-Aramaic: '4207'
        Mandaean (Mandaic): '4208'
        Middle Eastern Semitic Languages, nec: '4299'
    Turkic:
        Turkish: '4301'
        Azeri: '4302'
        Tatar: '4303'
        Turkmen: '4304'
        Uygur: '4305'
        Uzbek: '4306'
        Turkic, nec: '4399'
    Other Southwest and Central Asian Languages:
        Armenian: '4901'
        Georgian: '4902'
        Other Southwest and Central Asian Languages, nec: '4999'

SOUTHERN ASIAN LANGUAGES:
    Dravidian:
        Kannada: '5101'
        Malayalam: '5102'
        Tamil: '5103'
        Telugu: '5104'
        Tulu: '5105'
        Dravidian, nec: '5199'
    Indo-Aryan:
        Bengali: '5201'
        Gujarati: '5202'
        Hindi: '5203'
        Konkani: '5204'
        Marathi: '5205'
        Nepali: '5206'
        Punjabi: '5207'
        Sindhi: '5208'
        Sinhalese: '5211'
        Urdu: '5212'
        Assamese: '5213'
        Dhivehi: '5214'
        Kashmiri: '5215'
        Oriya: '5216'
        Fijian Hindustani: '5217'
        Indo-Aryan, nec: '5299'
    Other Southern Asian Languages:
        Other Southern Asian Languages: '5999'

SOUTHEAST ASIAN LANGUAGES:
    Burmese and Related Languages:
        Burmese: '6101'
        Chin Haka: '6102'
        Karen: '6103'
        Rohingya: '6104'
        Zomi: '6105'
        Burmese and Related Languages, nec: '6199'
    Hmong-Mien:
        Hmong: '6201'
        Hmong-Mien, nec: '6299'
    Mon-Khmer:
        Khmer: '6301'
        Vietnamese: '6302'
        Mon: '6303'
        Mon-Khmer, nec: '6399'
    Tai:
        Lao: '6401'
        Thai: '6402'
        Tai, nec: '6499'
    Southeast Asian Austronesian Languages:
        Bisaya: '6501'
        Cebuano: '6502'
        IIokano: '6503'
        Indonesian: '6504'
        Malay: '6505'
        Tetum: '6507'
        Timorese: '6508'
        Tagalog: '6511'
        Filipino: '6512'
        Acehnese: '6513'
        Balinese: '6514'
        Bikol: '6515'
        Iban: '6516'
        Ilonggo (Hiligaynon): '6517'
        Javanese: '6518'
        Pampangan: '6521'
        Southeast Asian Austronesian Languages, nec: '6599'
    Other Southeast Asian Languages:
        Other Southeast Asian Languages: '6999'

EASTERN ASIAN LANGUAGES:
    Chinese:
        Cantonese: '7101'
        Hakka: '7102'
        Mandarin: '7104'
        Wu: '7106'
        Min Nan: '7107'
        Chinese, nec: '7199'
    Japanese:
        Japanese: '7201'
    Korean:
        Korean: '7301'
    Other Eastern Asian Languages:
        Tibetan: '7901'
        Mongolian: '7902'
        Other Eastern Asian Languages, nec: '7999'

AUSTRALIAN INDIGENOUS LANGUAGES:
    Arnhem Land and Daly River Region Languages:
        Anindilyakwa: '8101'
        Maung: '8111'
        Ngan'gikurunggurr: '8113'
        Nunggubuyu: '8114'
        Rembarrnga: '8115'
        Tiwi: '8117'
        Alawa: '8121'
        Dalabon: '8122'
        Gudanji: '8123'
        Iwaidja: '8127'
        Jaminjung: '8128'
        Jawoyn: '8131'
        Jingulu: '8132'
        Kunbarlang: '8133'
        Larrakiya: '8136'
        Malak Malak: '8137'
        Mangarrayi: '8138'
        Maringarr: '8141'
        Marra: '8142'
        Marrithiyel: '8143'
        Matngala: '8144'
        Murrinh Patha: '8146'
        Na-kara: '8147'
        Ndjebbana (Gunavidji): '8148'
        Ngalakgan: '8151'
        Ngaliwurru: '8152'
        Nungali: '8153'
        Wambaya: '8154'
        Wardaman: '8155'
        Amurdak: '8156'
        Garrwa: '8157'
        Kuwema: '8158'
        Marramaninyshi: '8161'
        Ngandi: '8162'
        Waanyi: '8163'
        Wagiman: '8164'
        Yanyuwa: '8165'
        Marridan (Maridan): '8166'

        Gundjeihmi: '8171'
        Kune: '8172'
        Kuninjku: '8173'
        Kunwinjku: '8174'
        Mayali: '8175'
        Kunwinjkuan, nec: '8179'

        Burarra: '8181'
        Gun-nartpa: '8182'
        Gurr-goni: '8183'
        Burarran, nec: '8189'

        Arnhem Land and Daly River Region Languages, nec: '8199'
    Yolngu Matha:

        Galpu: '8211'
        Golumala: '8212'
        Wangurri: '8213'
        Dhangu, nec: '8219'

        Dhalwangu: '8221'
        Djarrwark: '8222'
        Dhay'yi, nec: '8229'

        Djambarrpuyngu: '8231'
        Djapu: '8232'
        Daatiwuy: '8233'
        Marrangu: '8234'
        Liyagalawumirr: '8235'
        Liyagawumirr: '8236'
        Dhuwal, nec: '8239'

        Gumatj: '8242'
        Gupapuyngu: '8243'
        Guyamirrilili: '8244'
        Manggalili: '8246'
        Wubulkarra: '8247'
        Dhuwala, nec: '8249'

        Wurlaki: '8251'
        Djinang, nec: '8259'

        Ganalbingu: '8261'
        Djinba: '8262'
        Manyjalpingu: '8263'
        Djinba, nec: '8269'

        Ritharrngu: '8271'
        Wagilak: '8272'
        Yakuy, nec: '8279'

        Nhangu: '8281'
        Yan-nhangu: '8282'
        Nhangu, nec: '8289'

        Dhuwaya: '8291'
        Djangu: '8292'
        Madarrpa: '8293'
        Warramiri: '8294'
        Rirratjingu: '8295'
        Other Yolngu Matha, nec: '8299'
    Cape York Peninsula Languages:
        Kuku Yalanji: '8301'
        Guugu Yimidhirr: '8302'
        Kuuku-Ya'u: '8303'
        Wik Mungkan: '8304'
        Djabugay: '8305'
        Dyirbal: '8306'
        Girramay: '8307'
        Koko-Bera: '8308'
        Kuuk Thayorre: '8311'
        Lamalama: '8312'
        Yidiny: '8313'
        Wik Ngathan: '8314'
        Alngith: '8315'
        Kugu Muminh: '8316'
        Morrobalama: '8317'
        Thaynakwith: '8318'
        Yupangathi: '8321'
        Tjungundji: '8322'
        Cape York Peninsula Languages, nec: '8399'
    Torres Strait Island Languages:
        Kalaw Kawaw Ya/Kalaw Lagaw Ya: '8401'
        Meriam Mir: '8402'
        Yumplatok (Torres Strait Creole): '8403'
    Northern Desert Fringe Area Languages:
        Bilinarra: '8504'
        Gurindji: '8505'
        Gurindji Kriol: '8506'
        Jaru: '8507'
        Light Warlpiri: '8508'
        Malngin: '8511'
        Mudburra: '8512'
        Ngardi: '8514'
        Ngarinyman: '8515'
        Walmajarri: '8516'
        Wanyjirra: '8517'
        Warlmanpa: '8518'
        Warlpiri: '8521'
        Warumungu: '8522'
        Northern Desert Fringe Area Languages, nec: '8599'
    Arandic:
        Alyawarr: '8603'
        Kaytetye: '8606'
        Antekerrepenh: '8607'

        Central Anmatyerr: '8611'
        Eastern Anmatyerr: '8612'
        Anmatyerr, nec: '8619'

        Eastern Arrernte: '8621'
        Western Arrarnta: '8622'
        Arrernte, nec: '8629'

        Arandic, nec: '8699'
    Western Desert Languages:
        Antikarinya: '8703'
        Kartujarra: '8704'
        Kukatha: '8705'
        Kukatja: '8706'
        Luritja: '8707'
        Manyjilyjarra: '8708'
        Martu Wangka: '8711'
        Ngaanyatjarra: '8712'
        Pintupi: '8713'
        Pitjantjatjara: '8714'
        Wangkajunga: '8715'
        Wangkatha: '8716'
        Warnman: '8717'
        Yankunytjatjara: '8718'
        Yulparija: '8721'
        Tjupany: '8722'
        Western Desert Languages, nec: '8799'
    Kimberley Area Languages:
        Bardi: '8801'
        Bunuba: '8802'
        Gooniyandi: '8803'
        Miriwoong: '8804'
        Ngarinyin: '8805'
        Nyikina: '8806'
        Worla: '8807'
        Worrorra: '8808'
        Wunambal: '8811'
        Yawuru: '8812'
        Gambera: '8813'
        Jawi: '8814'
        Kija: '8815'
        Kimberley Area Languages, nec: '8899'
    Other Australian Indigenous Languages:
        Adnymathanha: '8901'
        Arabana: '8902'
        Bandjalang: '8903'
        Banyjima: '8904'
        Batjala: '8905'
        Bidjara: '8906'
        Dhanggatti: '8907'
        Diyari: '8908'
        Gamilaraay: '8911'
        Garuwali: '8913'
        Githabul: '8914'
        Gumbaynggir: '8915'
        Kanai: '8916'
        Karajarri: '8917'
        Kariyarra: '8918'
        Kaurna: '8921'
        Kayardild: '8922'
        Kriol: '8924'
        Lardil: '8925'
        Mangala: '8926'
        Muruwari: '8927'
        Narungga: '8928'
        Ngarluma: '8931'
        Ngarrindjeri: '8932'
        Nyamal: '8933'
        Nyangumarta: '8934'
        Nyungar: '8935'
        Paakantyi: '8936'
        Palyku/Nyiyaparli: '8937'
        Wajarri: '8938'
        Wiradjuri: '8941'
        Yindjibarndi: '8943'
        Yinhawangka: '8944'
        Yorta Yorta: '8945'
        Baanbay: '8946'
        Badimaya: '8947'
        Barababaraba: '8948'
        Dadi Dadi: '8951'
        Dharawal: '8952'
        Djabwurrung: '8953'
        Gudjal: '8954'
        Keerray-Woorroong: '8955'
        Ladji Ladji: '8956'
        Mirning: '8957'
        Ngatjumaya: '8958'
        Waluwarra: '8961'
        Wangkangurru: '8962'
        Wargamay: '8963'
        Wergaia: '8964'
        Yugambeh: '8965'
        Aboriginal English, so described: '8998'
        Other Australian Indigenous Languages, nec: '8999'

OTHER LANGUAGES:
    American Languages:
        American Languages: '9101'
    African Languages:
        Acholi: '9201'
        Akan: '9203'
        Mauritian Creole: '9205'
        Oromo: '9206'
        Shona: '9207'
        Somali: '9208'
        Swahili: '9211'
        Yoruba: '9212'
        Zulu: '9213'
        Amharic: '9214'
        Bemba: '9215'
        Dinka: '9216'
        Ewe: '9217'
        Ga: '9218'
        Harari: '9221'
        Hausa: '9222'
        Igbo: '9223'
        Kikuyu: '9224'
        Krio: '9225'
        Luganda: '9226'
        Luo: '9227'
        Ndebele: '9228'
        Nuer: '9231'
        Nyanja (Chichewa): '9232'
        Shilluk: '9233'
        Tigre: '9234'
        Tigrinya: '9235'
        Tswana: '9236'
        Xhosa: '9237'
        Seychelles Creole: '9238'
        Anuak: '9241'
        Bari: '9242'
        Bassa: '9243'
        Dan (Gio-Dan): '9244'
        Fulfulde: '9245'
        Kinyarwanda (Rwanda): '9246'
        Kirundi (Rundi): '9247'
        Kpelle: '9248'
        Krahn: '9251'
        Liberian (Liberian English): '9252'
        Loma (Lorma): '9253'
        Lumun (Kuku Lumun): '9254'
        Madi: '9255'
        Mandinka: '9256'
        Mann: '9257'
        Moro (Nuba Moro): '9258'
        Themne: '9261'
        Lingala: '9262'
        African Languages, nec: '9299'
    Pacific Austronesian Languages:
        Fijian: '9301'
        Gilbertese: '9302'
        Maori (Cook Island): '9303'
        Maori (New Zealand): '9304'
        Nauruan: '9306'
        Niue: '9307'
        Samoan: '9308'
        Tongan: '9311'
        Rotuman: '9312'
        Tokelauan: '9313'
        Tuvaluan: '9314'
        Yapese: '9315'
        Pacific Austronesian Languages, nec: '9399'
    Oceanian Pidgins and Creoles:
        Bislama: '9402'
        Hawaiian English: '9403'
        Norf'k-Pitcairn: '9404'
        Solomon Islands Pijin: '9405'
        Oceanian Pidgins and Creoles, nec: '9499'
    Papua New Guinea Languages:
        Kiwai: '9502'
        Motu (HiriMotu): '9503'
        Tok Pisin (Neomelanesian): '9504'
        Papua New Guinea Languages, nec: '9599'
    Invented Languages:
        Invented Languages: '9601'
    Sign Languages:
        Auslan: '9701'
        Key Word Sign Australia: '9702'
        Sign Languages, nec: '9799'
    Miscellaneous:
        Unknown: '0000'
        Non Verbal: '0001'
        Not Stated: '@@@@'
");
		$entity->setName('AVETMISS.Client.language');
		$entity->setDisplayName('Language Identifier');
		$entity->setDescription('Language identifier uniquely identifies the main language other than English spoken at home by the client.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//14
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
Employed:
    Full-time employee: '01'
    Part-time employee: '02'
    Self-employed – not employing others: '03'
    Employer: '04'
    Employed – unpaid worker in a family business: '05'
Unemployed:
    Unemployed – seeking full-time work: '06'
    Unemployed – seeking part-time work: '07'
Not in the labour force:
    Not employed – not seeking employment: '08'
Not SPecified: '@@'
");
		$entity->setName('AVETMISS.Client.labourForce');
		$entity->setDisplayName('Labour Force Status Identifier');
		$entity->setDescription('Labour force status identifier describes a client’s employment status.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//15
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
OCEANIA AND ANTARCTICA:
    Australia (includes External Territories):
        Australia: '1101'
        Norfolk Island: '1102'
        Australian External Territories, nec: '1199'
    New Zealand:
        New Zealand: '1201'
    Melanesia:
        New Caledonia: '1301'
        Papua New Guinea: '1302'
        Solomon Islands: '1303'
        Vanuatu: '1304'
    Micronesia:
        Guam: '1401'
        Kiribati: '1402'
        Marshall Islands: '1403'
        Micronesia, Federated States of: '1404'
        Nauru: '1405'
        Northern Mariana Islands: '1406'
        Palau: '1407'
    Polynesia (excludes Hawaii):
        Cook Islands: '1501'
        Fiji: '1502'
        French Polynesia: '1503'
        Niue: '1504'
        Samoa: '1505'
        Samoa, American: '1506'
        Tokelau: '1507'
        Tonga: '1508'
        Tuvalu: '1511'
        Wallis and Futuna: '1512'
        Pitcairn Islands: '1513'
        Polynesia (excludes Hawaii), nec: '1599'
    Antarctica:
        Adelie Land (France): '1601'
        Argentinian Antarctic Territory: '1602'
        Australian Antarctic Territory: '1603'
        British Antarctic Territory: '1604'
        Chilean Antarctic Territory: '1605'
        Queen Maud Land (Norway): '1606'
        Ross Dependency (New Zealand): '1607'

NORTH-WEST EUROPE:
    United Kingdom, Channel Islands and Isle of Man:
        England: '2102'
        Isle of Man: '2103'
        Northern Ireland: '2104'
        Scotland: '2105'
        Wales: '2106'
        Guernsey: '2107'
        Jersey: '2108'
    Ireland:
        Ireland: '2201'
    Western Europe:
        Austria: '2301'
        Belgium: '2302'
        France: '2303'
        Germany: '2304'
        Liechtenstein: '2305'
        Luxembourg: '2306'
        Monaco: '2307'
        Netherlands: '2308'
        Switzerland: '2311'
    Northern Europe:
        Denmark: '2401'
        Faroe Islands: '2402'
        Finland: '2403'
        Greenland: '2404'
        Iceland: '2405'
        Norway: '2406'
        Sweden: '2407'
        Aland Islands: '2408'

SOUTHERN AND EASTERN EUROPE:
    Southern Europe:
        Andorra: '3101'
        Gibraltar: '3102'
        Holy See: '3103'
        Italy: '3104'
        Malta: '3105'
        Portugal: '3106'
        San Marino: '3107'
        Spain: '3108'
    South Eastern Europe:
        Albania: '3201'
        Bosnia and Herzegovina: '3202'
        Bulgaria: '3203'
        Croatia: '3204'
        Cyprus: '3205'
        The former Yugoslav Republic of Macedonia: '3206'
        Greece: '3207'
        Moldova: '3208'
        Romania: '3211'
        Slovenia: '3212'
        Montenegro: '3214'
        Serbia: '3215'
        Kosovo: '3216'
    Eastern Europe:
        Belarus: '3301'
        Czech Republic: '3302'
        Estonia: '3303'
        Hungary: '3304'
        Latvia: '3305'
        Lithuania: '3306'
        Poland: '3307'
        Russian Federation: '3308'
        Slovakia: '3311'
        Ukraine: '3312'

NORTH AFRICA AND THE MIDDLE EAST:
    North Africa:
        Algeria: '4101'
        Egypt: '4102'
        Libya: '4103'
        Morocco: '4104'
        Sudan: '4105'
        Tunisia: '4106'
        Western Sahara: '4107'
        Spanish North Africa: '4108'
        South Sudan: '4111'
    Middle East:
        Bahrain: '4201'
        Gaza Strip and West Bank: '4202'
        Iran: '4203'
        Iraq: '4204'
        Israel: '4205'
        Jordan: '4206'
        Kuwait: '4207'
        Lebanon: '4208'
        Oman: '4211'
        Qatar: '4212'
        Saudi Arabia: '4213'
        Syria: '4214'
        Turkey: '4215'
        United Arab Emirates: '4216'
        Yemen: '4217'

SOUTH-EAST ASIA:
    Mainland South-East Asia:
        Myanmar: '5101'
        Cambodia: '5102'
        Laos: '5103'
        Thailand: '5104'
        Vietnam: '5105'
    Maritime South-East Asia:
        Brunei Darussalam: '5201'
        Indonesia: '5202'
        Malaysia: '5203'
        Philippines: '5204'
        Singapore: '5205'
        Timor-Leste: '5206'

NORTH-EAST ASIA:
    Chinese Asia (includes Mongolia):
        China (excludes SARs and Taiwan): '6101'
        Hong Kong (SAR of China): '6102'
        Macau (SAR of China): '6103'
        Mongolia: '6104'
        Taiwan: '6105'
    Japan and the Koreas:
        Japan: '6201'
        Korea, Democratic People's Republic of (North): '6202'
        Korea, Republic of (South): '6203'

SOUTHERN AND CENTRAL ASIA:
    Southern Asia:
        Bangladesh: '7101'
        Bhutan: '7102'
        India: '7103'
        Maldives: '7104'
        Nepal: '7105'
        Pakistan: '7106'
        Sri Lanka: '7107'
    Central Asia:
        Afghanistan: '7201'
        Armenia: '7202'
        Azerbaijan: '7203'
        Georgia: '7204'
        Kazakhstan: '7205'
        Kyrgyzstan: '7206'
        Tajikistan: '7207'
        Turkmenistan: '7208'
        Uzbekistan: '7211'

AMERICAS:
    Northern America:
        Bermuda: '8101'
        Canada: '8102'
        St Pierre and Miquelon: '8103'
        United States of America: '8104'
    South America:
        Argentina: '8201'
        Bolivia: '8202'
        Brazil: '8203'
        Chile: '8204'
        Colombia: '8205'
        Ecuador: '8206'
        Falkland Islands: '8207'
        French Guiana: '8208'
        Guyana: '8211'
        Paraguay: '8212'
        Peru: '8213'
        Suriname: '8214'
        Uruguay: '8215'
        Venezuela: '8216'
        South America, nec: '8299'
    Central America:
        Belize: '8301'
        Costa Rica: '8302'
        El Salvador: '8303'
        Guatemala: '8304'
        Honduras: '8305'
        Mexico: '8306'
        Nicaragua: '8307'
        Panama: '8308'
    Caribbean:
        Anguilla: '8401'
        Antigua and Barbuda: '8402'
        Aruba: '8403'
        Bahamas: '8404'
        Barbados: '8405'
        Cayman Islands: '8406'
        Cuba: '8407'
        Dominica: '8408'
        Dominican Republic: '8411'
        Grenada: '8412'
        Guadeloupe: '8413'
        Haiti: '8414'
        Jamaica: '8415'
        Martinique: '8416'
        Montserrat: '8417'
        Puerto Rico: '8421'
        St Kitts and Nevis: '8422'
        St Lucia: '8423'
        St Vincent and the Grenadines: '8424'
        Trinidad and Tobago: '8425'
        Turks and Caicos Islands: '8426'
        Virgin Islands, British: '8427'
        Virgin Islands, United States: '8428'
        St Barthelemy: '8431'
        St Martin (French part): '8432'
        Bonaire, Sint Eustatius and Saba: '8433'
        Curacao: '8434'
        Sint Maarten (Dutch part): '8435'

SUB-SAHARAN AFRICA:
    Central and West Africa:
        Benin: '9101'
        Burkina Faso: '9102'
        Cameroon: '9103'
        Cabo Verde: '9104'
        Central African Republic: '9105'
        Chad: '9106'
        Congo, Republic of: '9107'
        Congo, Democratic Republic of: '9108'
        Cote d'Ivoire: '9111'
        Equatorial Guinea: '9112'
        Gabon: '9113'
        Gambia: '9114'
        Ghana: '9115'
        Guinea: '9116'
        Guinea-Bissau: '9117'
        Liberia: '9118'
        Mali: '9121'
        Mauritania: '9122'
        Niger: '9123'
        Nigeria: '9124'
        Sao Tome and Principe: '9125'
        Senegal: '9126'
        Sierra Leone: '9127'
        Togo: '9128'
    Southern and East Africa:
        Angola: '9201'
        Botswana: '9202'
        Burundi: '9203'
        Comoros: '9204'
        Djibouti: '9205'
        Eritrea: '9206'
        Ethiopia: '9207'
        Kenya: '9208'
        Lesotho: '9211'
        Madagascar: '9212'
        Malawi: '9213'
        Mauritius: '9214'
        Mayotte: '9215'
        Mozambique: '9216'
        Namibia: '9217'
        Reunion: '9218'
        Rwanda: '9221'
        St Helena: '9222'
        Seychelles: '9223'
        Somalia: '9224'
        South Africa: '9225'
        Swaziland: '9226'
        Tanzania: '9227'
        Uganda: '9228'
        Zambia: '9231'
        Zimbabwe: '9232'
        Southern and East Africa, nec: '9299'
OTHER:
    Not Specified: '@@@@'
");
		$entity->setName('AVETMISS.country');
		$entity->setDisplayName('Country Identifier');
		$entity->setDescription('Country identifier is a code that uniquely identifies a country.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//16
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
identifiers:
    'No Disability': '00'
    'Hearing/deaf': '11'
    'Physical': '12'
    'Intellectual': '13'
    'Learning': '14'
    'Mental illness': '15'
    'Acquired brain impairment': '16'
    'Vision': '17'
    'Medical condition': '18'
    'Other': '19'
help:
    '00': ''
    11: \"Hearing impairment is used to refer to a person who has an acquired mild, moderate or even a severe or profound hearing loss after learning to speak, communicates orally and maximises residual hearing with the assistance of amplification. A person who is deaf has a severe or profound hearing loss from, at, or near birth and mainly relies upon vision to communicate, whether through lip reading, gestures, cued speech, finger spelling and/or sign language.\"
    12: \"A physical disability affects the mobility or dexterity of a person and may include a total or partial loss of a part of the body. A physical disability may have existed since birth or may be the result of an accident, illness, or injury suffered later in life; for example, amputation, arthritis, cerebral palsy, multiple sclerosis, muscular dystrophy, paraplegia, quadriplegia or post-polio syndrome.\"
    13: \"There is diversity in the underlying concepts, definitions and classifications of intellectual disability adopted in Australia. In general, the term ‘intellectual disability’ is used to refer to low general intellectual functioning and difficulties in adaptive behaviour, both of which conditions were manifested before the person reached the age of 18. It may result from infection before or after birth, trauma during birth, or illness.\"
    14: \"There has been widespread debate in Australia and overseas regarding the causes and characteristics of learning disabilities. In recent years a definition proposed by the United States National Joint Committee for Learning Disabilities (NJCLD) has become widely accepted: A general term that refers to a heterogeneous group of disorders manifested by significant difficulties in the acquisition and use of listening, speaking, reading, writing, reasoning, or mathematical abilities. These disorders are intrinsic to the individual, presumed to be due to central nervous system dysfunction, and may occur across the life span. Problems in self-regulatory behaviours, social perception, and social interaction may exist with learning disabilities but do not by themselves constitute a learning disability. US National Joint Committee on Learning Disabilities 1988\"
    15: \"Mental illness refers to a cluster of psychological and physiological symptoms that cause a person suffering or distress and which represent a departure from a person’s usual pattern and level of functioning.\"
    16: \"Acquired brain impairment is injury to the brain that results in deterioration in cognitive, physical, emotional or independent functioning. Acquired brain impairment can occur as a result of trauma, hypoxia, infection, tumour, accidents, violence, substance abuse, degenerative neurological diseases or stroke. These impairments may be either temporary or permanent and cause partial or total disability or psychosocial maladjustment (Ministerial Implementation Committee on Head Injury 1995).\"
    17: \"A partial loss of sight causing difficulties in seeing, up to and including blindness. This may be present from birth or acquired as a result of disease, illness or injury.\"
    18: \"Medical condition is a temporary or permanent condition that may be hereditary, genetically acquired or of unknown origin. The condition may not be obvious or readily identifiable, yet may be mildly or severely debilitating and result in fluctuating levels of wellness and sickness, and/or periods of hospitalisation; for example, AIDS, cancer, chronic fatigue syndrome, Crohn’s disease, cystic fibrosis, asthma or diabetes.\"
    19: \"A disability, impairment or long-term condition which is not suitably described by one or several disability types in combination. Autism spectrum disorders are reported under this category.\"
");
		$entity->setName('AVETMISS.Client.Disability');
		$entity->setDisplayName('Disability Identifier');
		$entity->setDescription('Disability type identifier is a code that uniquely identifies the type(s) of disability, impairment or long-term condition that a client indicates.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//17
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
No post secondary education: '000'
Bachelor degree or higher degree level: '008'
Advanced diploma or associate degree level: '410'
Diploma level: '420'
Certificate IV: '511'
Certificate III: '514'
Certificate II: '521'
Certificate I: '524'
Miscellaneous education: '990'
");
		$entity->setName('AVETMISS.Client.PriorEducation');
		$entity->setDisplayName('Prior educational achievement identifier');
		$entity->setDescription('Prior educational achievement identifier uniquely identifies the level of non-schooling sector prior educational achievement successfully completed by a client.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);
		//18
		$entity = new \Busybee\Core\SystemBundle\Entity\Setting();
		$entity->setType('array');
		$entity->setValue("
Very well: '1'
Well: '2'
Not well: '3'
Not at all: '4'
Not Specified: '@'
");
		$entity->setName('AVETMISS.Client.EnglishProficiency');
		$entity->setDisplayName('Proficiency in Spoken English');
		$entity->setDescription('Proficiency in spoken English identifier is the self-assessed level of ability to speak English asked of people who speak a language other than English at home.');
		$entity->setChoice(null);
		$entity->setRole($role->findOneByRole('ROLE_ADMIN'));

		$this->sm->createSetting($entity);

		return true;
	}
}